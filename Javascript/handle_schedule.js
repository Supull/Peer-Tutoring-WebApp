document.addEventListener('click', function(event) {
    if (event.target.classList.contains('schedule-button')) {
        const requestId = event.target.getAttribute('data-request-id');
        const requester = event.target.getAttribute('data-requester');
        const tutor = event.target.getAttribute('data-tutor');

        // Set hidden input fields with the data attributes
        document.getElementById('requestId').value = requestId;
        document.getElementById('requester').value = requester;
        document.getElementById('tutor').value = tutor;

        // Display the modal
        document.getElementById('scheduleModal').style.display = 'flex';
    }

    if (event.target.classList.contains('close')) {
        document.getElementById('scheduleModal').style.display = 'none';
    }
});

window.onclick = function(event) {
    const modal = document.getElementById('scheduleModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};

document.addEventListener('click', function(event) {
    if (event.target.classList.contains('schedule-button')) {
        const scheduleTable = document.getElementById('scheduleTable');
        const headerRow = scheduleTable.querySelector('thead tr');
        const body = scheduleTable.querySelector('tbody');

        // Clear any existing content
        headerRow.innerHTML = '';
        body.innerHTML = '';

        const now = new Date();
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        // Fill in the header row with the next 7 days
        for (let i = 0; i < 7; i++) {
            const dayIndex = (now.getDay() + i) % 7;
            const dayName = days[dayIndex];
            const th = document.createElement('th');
            th.innerText = dayName;
            headerRow.appendChild(th);
        }

        // Fill in the time slots
        for (let hour = 0; hour < 24; hour++) {
            const tr = document.createElement('tr');

            for (let i = 0; i < 7; i++) {
                const td = document.createElement('td');
                const scheduleDate = new Date(now.getFullYear(), now.getMonth(), now.getDate() + i, hour);

                if (i === 0 && hour < now.getHours()) {
                    // Skip past hours on the current day
                    td.classList.add('time-slot', 'disabled');
                    td.innerText = '';
                } else {
                    td.dataset.datetime = scheduleDate.toISOString(); // This will be in UTC
                    td.innerText = `${hour}:00`;
                    td.classList.add('time-slot');
                }

                tr.appendChild(td);
            }

            body.appendChild(tr);
        }

        // Show the modal
        document.getElementById('scheduleModal').style.display = 'flex';
    }

    if (event.target.classList.contains('close')) {
        document.getElementById('scheduleModal').style.display = 'none';
    }
});

// Capture the selected time slot and set it in the hidden input
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('time-slot') && !event.target.classList.contains('disabled')) {
        const selectedDateTimeUTC = event.target.dataset.datetime;
        const selectedDateTime = new Date(selectedDateTimeUTC);
        const localDateTime = new Date(selectedDateTime.getTime() - selectedDateTime.getTimezoneOffset() * 60000);
        
        document.getElementById('scheduleDateTime').value = localDateTime.toISOString().slice(0, 16); // To get local date-time format

        // Highlight the selected slot
        const slots = document.querySelectorAll('.time-slot');
        slots.forEach(slot => slot.classList.remove('selected'));
        event.target.classList.add('selected');
    }
});


// Submit the form and send the selected schedule to the server
document.getElementById('scheduleForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const requestId = document.getElementById('requestId').value;
    const scheduleDateTime = document.getElementById('scheduleDateTime').value;
    const requester = document.getElementById('requester').value;
    const tutor = document.getElementById('tutor').value;

    if (!scheduleDateTime) {
        alert('Please select a time slot.');
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'includes2/store_schedule.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert(xhr.responseText);
            document.getElementById('scheduleModal').style.display = 'none';
        } else {
            alert('Error saving schedule.');
        }
    };
    xhr.send('request_id=' + encodeURIComponent(requestId) +
            '&schedule=' + encodeURIComponent(scheduleDateTime) +
            '&requester=' + encodeURIComponent(requester) +
            '&tutor=' + encodeURIComponent(tutor));
});


// Function to update the countdown timer
function updateCountdown() {
    const countdownElements = document.querySelectorAll('.countdown');
    const chatButtons = document.querySelectorAll('.chat-button');

    countdownElements.forEach((element, index) => {
        const scheduleTimestamp = parseInt(element.getAttribute('data-schedule'), 10);
        const chatButton = chatButtons[index]; // Corresponding chat button for this countdown

        if (!isNaN(scheduleTimestamp)) {
            const now = new Date().getTime();
            let distance = scheduleTimestamp - now;

            // Subtract 3 hours and 29 minutes
            const offsetHours = 3 * 60 * 60 * 1000; // 3 hours in milliseconds
            const offsetMinutes = 29 * 60 * 1000; // 29 minutes in milliseconds
            const totalOffset = offsetHours + offsetMinutes; // Total offset in milliseconds
            distance -= totalOffset;

            if (distance < 0) {
                // If the countdown is over
                element.innerHTML = "Time's up!";
                if (chatButton) chatButton.classList.remove('hidden-chat'); // Show chat button
            } else {
                // Calculate days, hours, minutes, and seconds
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Update the HTML content
                element.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            }
        } else {
            // Handle case where data-schedule is not a valid number
            element.innerHTML = "Invalid time data";
        }
    });
}

// Update countdown every second
setInterval(updateCountdown, 1000);