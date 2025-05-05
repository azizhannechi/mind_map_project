<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>nouveaux objectifs</title>
  <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsmind/style/jsmind.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    #jsmind_container {
      width: 100%;
      height: 600px;
      background-color: #f4f4f4;
      border: solid 1px #ccc;
      margin-top: 30px;
    }
  </style>
</head>
<body>


    <div class="container text-center py-5">
        <h1 class="mb-4">🎯 Crée ta carte mentale interactive</h1>
        <p class="lead mb-5">Organise tes objectifs en glissant-déposant les idées !</p>

    <div id="jsmind_container"></div>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jsmind/js/jsmind.js"></script>

<script>
    var mind = {
        "meta": {
            "name": "demo",
            "author": "chatgpt",
            "version": "1.0"
        },
        "format": "node_tree",
        "data": {
            "id": "root",
            "topic": "My Goals",
            "children": [
                {
                    "id": "goal1",
                    "topic": " goal1 ",
                    "children": [
                        {"id": "goal1.1", "topic": "write here  "},
                        {"id": "goal1.2", "topic": "write here"}
                    ]
                },
                {
                    "id": "goal2",
                    "topic": " goal2 ",
                    "children": [
                        {"id": "goal2.1", "topic": " write here"},
                        {"id": "goal2.2", "topic": " write here "}
                    ]
                }
            ]
        }
    };

    var options = {
        container: 'jsmind_container',
        editable: true,
        theme: 'primary'
    };
    var jm = new jsMind(options);
    jm.show(mind);
</script>

</body>
</html><?php /**PATH E:\mind_map_project\mind_map_project\resources\views/nouveauObjectif.blade.php ENDPATH**/ ?>