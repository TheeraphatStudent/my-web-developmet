let currentDate = new Date();
let selectedDate = null;

// Simulated database events
const events = {
    '2025-02-26': [
        {
            title: 'Eat with me',
            description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            fullDescription: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            location: 'Restaurant ABC',
            time: '12:30 PM'
        },
        // {
        //     title: 'A',
        //     description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        //     fullDescription: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        //     location: 'Restaurant ABC',
        //     time: '12:30 PM'
        // },
        // {
        //     title: 'B',
        //     description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        //     fullDescription: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        //     location: 'Restaurant ABC',
        //     time: '12:30 PM'
        // },
        // {
        //     title: 'C',
        //     description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        //     fullDescription: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        //     location: 'Restaurant ABC',
        //     time: '12:30 PM'
        // },
        // {
        //     title: 'D',
        //     description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        //     fullDescription: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        //     location: 'Restaurant ABC',
        //     time: '12:30 PM'
        // },
        // {
        //     title: 'E',
        //     description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        //     fullDescription: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        //     location: 'Restaurant ABC',
        //     time: '12:30 PM'
        // },
        // {
        //     title: 'E',
        //     description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        //     fullDescription: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        //     location: 'Restaurant ABC',
        //     time: '12:30 PM'
        // },
        // {
        //     title: 'E',
        //     description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        //     fullDescription: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        //     location: 'Restaurant ABC',
        //     time: '12:30 PM'
        // },
        // {
        //     title: 'E',
        //     description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        //     fullDescription: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        //     location: 'Restaurant ABC',
        //     time: '12:30 PM'
        // },
        // {
        //     title: 'E',
        //     description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        //     fullDescription: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        //     location: 'Restaurant ABC',
        //     time: '12:30 PM'
        // },
    ],
};

const renderCalendar = () => {
    console.log("Render Calendar Work!")

    const calendar = document.getElementById('calendar');
    const currentMonthElement = document.getElementById('currentMonth');
    const monthEventsElement = document.getElementById('monthEvents');

    calendar.innerHTML = '';
    monthEventsElement.innerHTML = '';

    const monthYearString = new Date(
        currentDate.getFullYear(),
        currentDate.getMonth()
    ).toLocaleString('default', { month: 'long', year: 'numeric' });
    currentMonthElement.textContent = monthYearString;

    const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);

    // Date Cell Init
    for (let i = 0; i < firstDay.getDay(); i++) {
        const emptyDay = document.createElement('div');
        emptyDay.className = 'calendar-day bg-dark-primary/20 rounded';
        calendar.appendChild(emptyDay);
    }

    const monthEvents = [];

    for (let day = 1; day <= lastDay.getDate(); day++) {
        const dateCell = document.createElement('div');
        const dateString = `${currentDate.getFullYear()}-${(currentDate.getMonth() + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;

        dateCell.className = 'calendar-day bg-white rounded p-2 border cursor-pointer hover:bg-gray-50';
        dateCell.innerHTML = `
          <div class="font-semibold">${day}</div>
          <div class="flex flex-wrap mt-1" id="events-${dateString}"></div>
        `;

        const eventsContainer = dateCell.querySelector(`#events-${dateString} `);
        eventsContainer.classList = 'flex flex-wrap w-full max-w-[80px] md:max-w-[60px] sm:max-w-[40px] h-[clamp(40px,15vw,60px)] gap-1';

        // Show icon on calendar
        if (events[dateString]) {

            events[dateString].forEach((event, index) => {
                console.log(`Event Notify: ${event.title} at ${event.time} on ${day} ${monthYearString} Month`);

                const eventDot = document.createElement('div');
                eventDot.className = 'w-2 h-2 rounded-full bg-secondary m-0.5';
                eventsContainer.appendChild(eventDot);

                monthEvents.push({
                    date: dateString,
                    day: day,
                    event: event,
                    index: index
                });
            });

            dateCell.addEventListener('click', () => {
                showEventDetails(dateString, 0);
            });
        }

        calendar.appendChild(dateCell);
    }

    monthEvents.forEach(({ date, day, event }) => {
        const eventElement = document.createElement('div');
        eventElement.className = 'p-4 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100';
        eventElement.innerHTML = `
            <div div class="font-semibold" > ${event.title}</div >
      <div class="text-sm text-gray-600">Date: ${day} ${monthYearString}</div>
      <div class="text-sm text-gray-600">Time: ${event.time}</div>
        `;
        eventElement.addEventListener('click', () => {
            showEventDetails(date, 0);
        });
        monthEventsElement.appendChild(eventElement);
    });
}

// Event Handlers
document.getElementById('prevMonth').addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

document.getElementById('nextMonth').addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

document.getElementById('closeDetailsModal').addEventListener('click', () => {
    document.getElementById('eventDetailsModal').classList.add('hidden');
});

// Show event details
const showEventDetails = (date, eventIndex) => {
    const event = events[date][eventIndex];
    document.getElementById('detailsTitle').textContent = event.title;
    document.getElementById('detailsDescription').textContent = event.description;

    const actionsContainer = document.querySelector('#eventDetailsModal .flex.justify-end');
    actionsContainer.innerHTML = `
            <button button id = "moreDetails" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" > More Details</button >
                <button id="closeDetailsModal" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Close</button>
        `;

    document.getElementById('moreDetails').addEventListener('click', () => {
        document.getElementById('detailsDescription').textContent = event.fullDescription;
        document.getElementById('detailsDescription').innerHTML += `
            <div div class="mt-2" >
        <p class="text-gray-700"><strong>Location:</strong> ${event.location}</p>
        <p class="text-gray-700"><strong>Time:</strong> ${event.time}</p>
      </div >
    `;
    });

    document.getElementById('closeDetailsModal').addEventListener('click', () => {
        document.getElementById('eventDetailsModal').classList.add('hidden');
    });

    document.getElementById('eventDetailsModal').classList.remove('hidden');
}

// Loaded Content
document.addEventListener('DOMContentLoaded', () => {
    renderCalendar();
})