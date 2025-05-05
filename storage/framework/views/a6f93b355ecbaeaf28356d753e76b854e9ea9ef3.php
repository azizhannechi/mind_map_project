extends('layouts.app') 

<?php $__env->startSection('title', 'Calendrier Élégant'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">

  <header class="header">
    <h1>Mon Calendrier Élégant</h1>
    <p>Restez organisé facilement !</p>
  </header>

  <div class="calendar-container">
    <div class="month-header">
      <button class="nav-button" onclick="changeMonth(-1)">←</button>
      <div class="month-year" id="monthDisplay"></div>
      <button class="nav-button" onclick="changeMonth(1)">→</button>
    </div>

    <div class="days-header">
      <div class="day-header">Lun</div>
      <div class="day-header">Mar</div>
      <div class="day-header">Mer</div>
      <div class="day-header">Jeu</div>
      <div class="day-header">Ven</div>
      <div class="day-header">Sam</div>
      <div class="day-header">Dim</div>
    </div>

    <div class="dates-grid" id="datesGrid"></div>
  </div>

  <div id="selectedDateDisplay"></div>

  <div class="message-box" id="messageBox" style="display: none;">
    <form id="calendarForm" method="POST" action="<?php echo e(route('calendrier.store')); ?>">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="selected_date" id="selected_date">
      <textarea name="message" id="userMessage" placeholder="Écrivez l'objectif pour cette date..."></textarea>
      <div class="buttons">
        <a class="action-button" href="<?php echo e(url('/')); ?>">🏠 Retour</a>
        <button type="submit" class="action-button">💾 Enregistrer</button>
      </div>
    </form>
  </div>

</div>


<style>
  /* INCLURE TOUT LE CSS DÉJÀ FOURNI ICI */
</style>


<script>
  const monthDisplay = document.getElementById('monthDisplay');
  const datesGrid = document.getElementById('datesGrid');
  const selectedDateDisplay = document.getElementById('selectedDateDisplay');
  const messageBox = document.getElementById('messageBox');
  const userMessage = document.getElementById('userMessage');
  const selectedDateInput = document.getElementById('selected_date');

  const months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];

  let today = new Date();
  let currentMonth = today.getMonth();
  let currentYear = today.getFullYear();
  let selectedDate = null;

  function renderCalendar(month, year) {
    monthDisplay.textContent = `${months[month]} ${year}`;
    datesGrid.innerHTML = "";

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startDay = (firstDay.getDay() + 6) % 7;

    for (let i = 0; i < startDay; i++) {
      const emptyCell = document.createElement('div');
      datesGrid.appendChild(emptyCell);
    }

    for (let day = 1; day <= lastDay.getDate(); day++) {
      const dateCell = document.createElement('div');
      dateCell.classList.add('date');
      dateCell.textContent = day;

      if (
        day === today.getDate() &&
        month === today.getMonth() &&
        year === today.getFullYear()
      ) {
        dateCell.classList.add('today');
      }

      dateCell.addEventListener('click', () => {
        document.querySelectorAll('.date').forEach(d => d.classList.remove('selected'));
        dateCell.classList.add('selected');
        selectedDate = new Date(year, month, day);
        showSelectedDate();
      });

      datesGrid.appendChild(dateCell);
    }
  }

  function changeMonth(offset) {
    currentMonth += offset;
    if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    } else if (currentMonth < 0) {
      currentMonth = 11;
      currentYear--;
    }
    renderCalendar(currentMonth, currentYear);
  }

  function showSelectedDate() {
    if (selectedDate) {
      selectedDateDisplay.innerHTML = `
        <div class="selected-date">
          📅 Date sélectionnée : ${selectedDate.getDate()}/${selectedDate.getMonth() + 1}/${selectedDate.getFullYear()}
        </div>
      `;
      messageBox.style.display = "block";
      selectedDateInput.value = `${selectedDate.getFullYear()}-${(selectedDate.getMonth() + 1).toString().padStart(2, '0')}-${selectedDate.getDate().toString().padStart(2, '0')}`;
      userMessage.value = "";
    }
  }

  renderCalendar(currentMonth, currentYear);
</script>
<?php $__env->stopSection(); ?>
<?php /**PATH E:\mind_map_project\mind_map_project\resources\views/calendrier.blade.php ENDPATH**/ ?>