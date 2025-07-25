document.addEventListener('DOMContentLoaded', function() {
    const calendar = {
        init() {
            this.calendarTitle = document.getElementById('calendar-title');
            this.calendarBody = document.getElementById('calendar-body');
            
            if (!this.calendarTitle || !this.calendarBody) {
                console.error('Required calendar elements not found');
                return;
            }

            this.today = new Date();
            this.currentMonth = this.today.getMonth();
            this.currentYear = this.today.getFullYear();
            
            this.render();
        },

        monthNames: [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ],

        getDaysInMonth(month, year) {
            return new Date(year, month + 1, 0).getDate();
        },

        getFirstDayOfMonth(month, year) {
            return new Date(year, month, 1).getDay();
        },

        isToday(day, month, year) {
            return day === this.today.getDate() &&
                   month === this.today.getMonth() &&
                   year === this.today.getFullYear();
        },

        render() {
            // Update calendar title
            this.calendarTitle.textContent = `📅 ${this.monthNames[this.currentMonth]} ${this.currentYear}`;
            
            const daysInMonth = this.getDaysInMonth(this.currentMonth, this.currentYear);
            const firstDayOfMonth = this.getFirstDayOfMonth(this.currentMonth, this.currentYear);
            
            let html = '';
            let dayCount = 1;
            
            // Create weeks
            for (let i = 0; i < 6; i++) {
                let row = '<tr>';
                
                // Create days
                for (let j = 0; j < 7; j++) {
                    if (i === 0 && j < firstDayOfMonth) {
                        // Empty cells before first day
                        row += '<td class="py-2 text-slate-400"></td>';
                    } else if (dayCount > daysInMonth) {
                        // Empty cells after last day
                        row += '<td class="py-2 text-slate-400"></td>';
                    } else {
                        // Regular day cells
                        if (this.isToday(dayCount, this.currentMonth, this.currentYear)) {
                            // Today's cell
                            row += `
                                <td class="py-2">
                                    <span class="today-highlight">${dayCount}</span>
                                </td>`;
                        } else {
                            // Regular cell
                            row += `<td class="py-2">${dayCount}</td>`;
                        }
                        dayCount++;
                    }
                }
                
                row += '</tr>';
                html += row;
                
                if (dayCount > daysInMonth) break;
            }
            
            this.calendarBody.innerHTML = html;
        }
    };

    // Initialize the calendar
    calendar.init();
});




