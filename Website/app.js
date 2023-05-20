const menu = document.querySelector('#mobile-menu')
const menuLinks = document.querySelector('.navbar__menu')

menu.addEventListener('click', function(){
    menu.classList.toggle('is-active');  
    menuLinks.classList.toggle('active');
})


// Get the necessary elements
const dateInput = document.getElementById('date-input');
const calendarPopup = document.querySelector('.calendar-popup');
const currentMonthElement = document.querySelector('.current-month');
const calendarDaysElement = document.querySelector('.calendar-days');
const prevMonthBtn = document.querySelector('.prev-month-btn');
const nextMonthBtn = document.querySelector('.next-month-btn');

// Open the calendar popup on input click
dateInput.addEventListener('click', function() {
  calendarPopup.style.display = 'block';
});

// Close the calendar popup if user clicks outside
document.addEventListener('click', function(event) {
  if (!dateInput.contains(event.target) && !calendarPopup.contains(event.target)) {
    calendarPopup.style.display = 'none';
  }
});

// Generate and display the calendar
function generateCalendar(year, month) {
  const firstDay = new Date(year, month, 1).getDay();
  const lastDate = new Date(year, month + 1, 0).getDate();

  currentMonthElement.textContent = new Date(year, month).toLocaleString('default', { month: 'long', year: 'numeric' });
  calendarDaysElement.innerHTML = '';

  // Fill in the days
  for (let i = 0; i < firstDay; i++) {
    const emptyDay = document.createElement('button');
    emptyDay.disabled = true;
    calendarDaysElement.appendChild(emptyDay);
  }

  for (let day = 1; day <= lastDate; day++) {
    const calendarDay = document.createElement('button');
    calendarDay.textContent = day;
    calendarDay.addEventListener('click', function() {
      dateInput.value = new Date(year, month, day).toLocaleDateString('en-US');
      calendarPopup.style.display = 'none';
    });
    calendarDaysElement.appendChild(calendarDay);
  }
}

// Initialize the calendar with the current month
const currentDate = new Date();
const currentYear = currentDate.getFullYear();
const currentMonth = currentDate.getMonth();
generateCalendar(currentYear, currentMonth);

// Event listeners for navigating between months
prevMonthBtn.addEventListener('click', function() {
  currentMonth--;
  if (currentMonth < 0) {
    currentYear--;
    currentMonth = 11;
  }
  generateCalendar(currentYear, currentMonth);
});

nextMonthBtn.addEventListener('click', function() {
  currentMonth++;
  if (currentMonth > 11) {
    currentYear++;
    currentMonth = 0;
  }
  generateCalendar(currentYear, currentMonth);
});
