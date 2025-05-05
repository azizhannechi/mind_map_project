document.addEventListener('DOMContentLoaded', function () {
    const objectifForm = document.querySelector('#newGoalModal form');
    if (objectifForm) {
        objectifForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Empêche le rechargement de la page

            const formData = new FormData(objectifForm);
            // Soumission avec AJAX
            fetch(objectifForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    const newObjectif = data; // Utiliser les données renvoyées par le serveur

                    // Ajouter l'objectif aux visualisations (GoJS et Leaflet)
                    addObjectifToMindMap(newObjectif);
                    addObjectifToMap(newObjectif);

                    // Fermer le modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('newGoalModal'));
                    modal.hide();

                    // Réinitialiser le formulaire
                    objectifForm.reset();
                })
                .catch(error => console.error('Erreur lors de la création de l\'objectif:', error));
        });
    }
});

// Variables globales pour les références aux cartes
let myDiagram;
let myMap;
let objectifsData = window.objectifsFromLaravel || [];

// ====== CARTE MENTALE AVEC GOJS ======
function initMindMap() {
    const $ = go.GraphObject.make;

    myDiagram = $(go.Diagram, "mindmap", {
        "undoManager.isEnabled": true,
        layout: $(go.TreeLayout, {
            angle: 90,
            nodeSpacing: 10,
            layerSpacing: 40
        })
    });

    // Définition du modèle de nœud pour les objectifs
    myDiagram.nodeTemplate =
        $(go.Node, "Auto",
            {
                selectionAdorned: true,
                fromSpot: go.Spot.Right,
                toSpot: go.Spot.Left
            },
            $(go.Shape, "RoundedRectangle", {
                fill: function (d) {
                    // Couleur selon la catégorie
                    const categories = {
                        "Études": "#4a6fa5",
                        "Sport": "#ff7e5f",
                        "Lecture": "#6b8cae",
                        "Projets": "#7986cb",
                        "Santé": "#81c784",
                        "Autre": "#9575cd"
                    };
                    return categories[d.data.categorie] || "#4a6fa5";
                },
                stroke: "white",
                strokeWidth: 2
            }),
            $(go.Panel, "Vertical",
                { margin: 8 },
                $(go.TextBlock, {
                    margin: new go.Margin(0, 0, 4, 0),
                    font: "bold 12px sans-serif",
                    stroke: "white",
                    wrap: go.TextBlock.WrapFit,
                    textAlign: "center"
                }, new go.Binding("text", "nom")),
                $(go.Panel, "Auto",
                    $(go.Shape, "Rectangle", {
                        fill: "white", 
                        height: 10, 
                        stroke: null
                    }),
                    $(go.Shape, "Rectangle", {
                        fill: "#4CAF50", 
                        height: 10, 
                        stroke: null
                    }, new go.Binding("width", "progression", function (progress) {
                        return (progress / 100) * 100; // Largeur en fonction de la progression
                    }))
                )
            )
        );

    // Définition du modèle de lien entre les objectifs
    myDiagram.linkTemplate =
        $(go.Link, {
            routing: go.Link.AvoidsNodes,
            curve: go.Link.JumpOver,
            corner: 5
        },
            $(go.Shape, { strokeWidth: 2, stroke: "#555" }));

    // Création du modèle de données et des liens entre les objectifs
    const nodes = [];
    const links = [];

    // Nœud central (utilisateur)
    nodes.push({ key: "central", nom: "Vos objectifs", categorie: "central", progression: 0 });

    // Ajout des objectifs comme nœuds
    if (objectifsData && objectifsData.length > 0) {
        objectifsData.forEach(obj => {
            nodes.push({
                key: obj.id.toString(),
                nom: obj.nom,
                categorie: obj.categorie,
                progression: obj.progression || 0
            });
            // Lien avec le nœud central
            links.push({ from: "central", to: obj.id.toString() });
        });
    }

    // Application du modèle au diagramme
    myDiagram.model = new go.GraphLinksModel(nodes, links);
}

// Fonction pour ajouter un nouvel objectif à la carte mentale
function addObjectifToMindMap(objectif) {
    if (!myDiagram) return;

    const model = myDiagram.model;
    model.startTransaction("add objectif");

    // Ajouter le nœud de l'objectif
    model.addNodeData({
        key: objectif.id.toString(),
        nom: objectif.nom,
        categorie: objectif.categorie,
        progression: objectif.progression || 0
    });

    // Ajouter le lien au nœud central
    model.addLinkData({ from: "central", to: objectif.id.toString() });

    model.commitTransaction("add objectif");
}

// ====== CARTE GÉOGRAPHIQUE AVEC LEAFLET ======
function initLeafletMap() {
    // Initialisation de la carte Leaflet centrée sur la France
    myMap = L.map('map').setView([46.603354, 1.888334], 5);

    // Ajout de la couche OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 18
    }).addTo(myMap);

    // Création des marqueurs pour chaque objectif avec localisation
    if (objectifsData && objectifsData.length > 0) {
        objectifsData.forEach(obj => {
            if (obj.latitude && obj.longitude) {
                addMarkerToMap(obj);
            }
        });
    }
}

// Fonction pour ajouter un marqueur à la carte Leaflet
function addObjectifToMap(objectif) {
    if (!myMap) return;

    // Vérification des coordonnées
    if (objectif.latitude && objectif.longitude) {
        addMarkerToMap(objectif);
    } else if (objectif.lieu) {
        geocodeLocation(objectif.lieu).then(coords => {
            if (coords) {
                objectif.latitude = coords.lat;
                objectif.longitude = coords.lng;
                addMarkerToMap(objectif);
            } else {
                alert("L'adresse n'a pas pu être géocodée.");
            }
        });
    }
}

// Fonction pour ajouter un marqueur à la carte avec les coordonnées connues
function addMarkerToMap(objectif) {
    // Définir une couleur selon la catégorie
    const categoryColors = {
        "Études": "#4a6fa5",
        "Sport": "#ff7e5f",
        "Lecture": "#6b8cae",
        "Projets": "#7986cb",
        "Santé": "#81c784",
        "Autre": "#9575cd"
    };

    const markerIcon = L.divIcon({
        html: `<div style="background-color: ${categoryColors[objectif.categorie] || '#4a6fa5'}; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white;"></div>`,
        className: 'objectif-marker',
        iconSize: [16, 16],
        iconAnchor: [8, 8]
    });

    const marker = L.marker([objectif.latitude, objectif.longitude], { icon: markerIcon }).addTo(myMap);

    // Popup avec les informations de l'objectif
    marker.bindPopup(`
        <strong>${objectif.nom}</strong><br>
        <span class="badge" style="background-color: ${categoryColors[objectif.categorie] || '#4a6fa5'}">${objectif.categorie}</span><br>
        ${objectif.description ? objectif.description + '<br>' : ''}
        <div class="progress mt-2" style="height: 5px;">
            <div class="progress-bar" role="progressbar" style="width: ${objectif.progression || 0}%; background-color: ${categoryColors[objectif.categorie] || '#4a6fa5'}" aria-valuenow="${objectif.progression || 0}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <small class="mt-1">${objectif.progression || 0}% complété</small>
    `);
}

// Fonction pour géocoder un lieu (convertir une adresse en coordonnées)
function geocodeLocation(address) {
    // Utilisation de l'API Nominatim d'OpenStreetMap pour le géocodage
    return fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                return {
                    lat: parseFloat(data[0].lat),
                    lng: parseFloat(data[0].lon)
                };
            }
            return null;
        })
        .catch(error => {
            console.error('Erreur lors du géocodage:', error);
            return null;
        });
}
