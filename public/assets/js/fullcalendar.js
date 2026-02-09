//Full Calendar
document.addEventListener('DOMContentLoaded', function() {
	var containerEl = document.getElementById('external-events');
	new FullCalendar.Draggable(containerEl, {
	  itemSelector: '.fc-event',
	  eventData: function(eventEl) {
		return {
		  title: eventEl.innerText.trim(),
		  title: eventEl.innerText,
		className: eventEl.className + ' overflow-hidden '
		}
	  }
	});
	var calendarEl = document.getElementById('calendar2');

	var calendar = new FullCalendar.Calendar(calendarEl, {
          locale: 'pt-br',
	  headerToolbar: {
		left: 'prev,next today',
		center: 'title',
		right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
	  },
          buttonText: {
            today: 'hoje',
            month: 'mes',
            week: 'semana',
            day: 'dia'
          },
	  defaultView: 'month',
	  navLinks: true, // can click day/week names to navigate views
	  businessHours: true, // display business hours
	  editable: false,
	  selectable: true,
	  selectMirror: true,
	  droppable: false, // this allows things to be dropped onto the calendar
	  select: function(arg) {
		var title = prompt('Event Title:');
		if (title) {
		  calendar.addEvent({
			title: title,
			start: arg.start,
			end: arg.end,
			allDay: arg.allDay
		  })
		}
		calendar.unselect()
	  },
	  
	  editable: true,
	  dayMaxEvents: true, // allow "more" link when too many events
	  events: [{
		title: 'Conference',
		start: '2022-03-01',
		end: '2022-03-15',
		color: '#f74f75'
	}, {
		title: 'Party',
		start: '2021-11-29T20:00:00',
		color: '#ffbd5a'
	},
	// areas where "Meeting" must be dropped
	{
		id: 'availableForMeeting',
		start: '2021-10-11T10:00:00',
		end: '2021-10-11T16:00:00',
		rendering: 'background',
		color: '#f34343'
	}, {
		id: 'availableForMeeting',
		start: '2021-10-13T10:00:00',
		end: '2021-10-13T16:00:00',
		rendering: '#4ec2f0'
	}, {
		title: 'Jyo birthday',
		id: 'Jyo birthday',
		start: '2021-12-19T10:00:00',
		end: '2021-12-19T16:00:00',
		rendering: '#4ec2f0'
	}, {
		title: 'Chandu birthday',
		id: 'Jyo birthday',
		start: '2021-11-30T10:00:00',
		end: '2021-11-30T16:00:00',
		rendering: '#4ec2f0'
	},
]
	});

	calendar.render();
});	
  