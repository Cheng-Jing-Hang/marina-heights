document.addEventListener("DOMContentLoaded", () => {
    const calendarTitle = document.getElementById("calendar-title");
    const calendarBody = document.getElementById("calendar-body");

    const today = new Date();
    const currentMonth = today.getMonth(); // 0 = Jan, 1 = Feb, ...
    const currentYear = today.getFullYear();

    generateCalendar(currentMonth, currentYear);

    function generateCalendar(month, year) {
        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        // Get the first day of the month (0 for Sunday, 1 for Monday, etc.)
        const firstDay = new Date(year, month, 1).getDay();
        // Get the number of days in the current month
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Set the calendar title (e.g., "📅 July 2024")
        calendarTitle.textContent = `📅 ${monthNames[month]} ${year}`;

        // Clear any existing calendar days
        calendarBody.innerHTML = "";

        let date = 1;
        // Loop to create up to 6 rows (weeks) in the calendar
        for (let i = 0; i < 6; i++) {
            const row = document.createElement("tr");

            // Loop for each day of the week (7 days)
            for (let j = 0; j < 7; j++) {
                const cell = document.createElement("td");
                cell.classList.add('py-2'); // Add padding for spacing

                if (i === 0 && j < firstDay) {
                    // Fill leading empty cells before the first day of the month
                    cell.textContent = "";
                    cell.classList.add('text-slate-400'); // Style for empty cells
                } else if (date > daysInMonth) {
                    // Fill trailing empty cells after the last day of the month
                    cell.textContent = "";
                    cell.classList.add('text-slate-400'); // Style for empty cells
                } else {
                    // Populate with the date
                    cell.textContent = date;
                    // Highlight today's date
                    if (date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                        cell.classList.add('bg-blue-500', 'text-white', 'font-bold', 'rounded-full');
                    }
                    date++;
                }
                row.appendChild(cell);
            }
            calendarBody.appendChild(row);

            // Stop if all days of the month have been added
            if (date > daysInMonth) {
                break;
            }
        }
    }
});