// dashboard.js
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    function handleResponsiveLayout() {
        const screenWidth = window.innerWidth;
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        
        if (screenWidth <= 992) {
            // Mobile layout
            sidebar.classList.add('collapsed');
            mainContent.style.marginLeft = '70px';
            
            // Add hover effect to sidebar
            sidebar.addEventListener('mouseenter', expandSidebar);
            sidebar.addEventListener('mouseleave', collapseSidebar);
        } else {
            // Desktop layout
            sidebar.classList.remove('collapsed');
            mainContent.style.marginLeft = '260px';
            
            // Remove hover events on desktop
            sidebar.removeEventListener('mouseenter', expandSidebar);
            sidebar.removeEventListener('mouseleave', collapseSidebar);
        }
    }
    
    function expandSidebar() {
        if (window.innerWidth <= 992) {
            this.style.width = '260px';
            document.querySelectorAll('.logo h2, .main-nav li a span').forEach(el => {
                el.style.display = 'block';
            });
            document.querySelectorAll('.main-nav li a').forEach(el => {
                el.style.justifyContent = 'flex-start';
                el.style.padding = '12px 20px';
            });
            document.querySelectorAll('.main-nav li a i').forEach(el => {
                el.style.marginRight = '10px';
            });
        }
    }
    
    function collapseSidebar() {
        if (window.innerWidth <= 992) {
            this.style.width = '70px';
            document.querySelectorAll('.logo h2, .main-nav li a span').forEach(el => {
                el.style.display = 'none';
            });
            document.querySelectorAll('.main-nav li a').forEach(el => {
                el.style.justifyContent = 'center';
                el.style.padding = '15px 0';
            });
            document.querySelectorAll('.main-nav li a i').forEach(el => {
                el.style.marginRight = '0';
            });
        }
    }
    
    // Initialize responsive layout
    handleResponsiveLayout();
    
    // Update layout on window resize
    window.addEventListener('resize', handleResponsiveLayout);
    
    // Active menu item highlighting
    const currentLocation = window.location.pathname;
    const menuItems = document.querySelectorAll('.main-nav li a');
    
    menuItems.forEach(item => {
        if (item.getAttribute('href') === currentLocation) {
            item.parentElement.classList.add('active');
        }
    });
    
    // Notifications dropdown
    const notificationsIcon = document.querySelector('.notifications');
    if (notificationsIcon) {
        // Create dropdown element
        const dropdown = document.createElement('div');
        dropdown.className = 'notifications-dropdown';
        dropdown.style.display = 'none';
        dropdown.style.position = 'absolute';
        dropdown.style.right = '0';
        dropdown.style.top = '100%';
        dropdown.style.width = '300px';
        dropdown.style.backgroundColor = '#fff';
        dropdown.style.borderRadius = '8px';
        dropdown.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
        dropdown.style.zIndex = '100';
        dropdown.style.padding = '10px 0';
        
        // Add notification items
        dropdown.innerHTML = `
            <div style="padding: 10px 15px; border-bottom: 1px solid #e2e8f0;">
                <h3 style="font-size: 16px; margin-bottom: 5px;">Notifications</h3>
                <p style="font-size: 12px; color: #666;">You have 3 unread notifications</p>
            </div>
            <div style="padding: 10px 15px; display: flex; align-items: flex-start; border-bottom: 1px solid #e2e8f0;">
                <div style="background-color: #4a90e2; color: white; border-radius: 50%; width: 10px; height: 10px; margin-right: 10px; margin-top: 5px;"></div>
                <div>
                    <p style="font-size: 14px; margin-bottom: 5px;">New adoption application submitted</p>
                    <p style="font-size: 12px; color: #999;">5 minutes ago</p>
                </div>
            </div>
            <div style="padding: 10px 15px; display: flex; align-items: flex-start; border-bottom: 1px solid #e2e8f0;">
                <div style="background-color: #4a90e2; color: white; border-radius: 50%; width: 10px; height: 10px; margin-right: 10px; margin-top: 5px;"></div>
                <div>
                    <p style="font-size: 14px; margin-bottom: 5px;">Donation received from John Smith</p>
                    <p style="font-size: 12px; color: #999;">2 hours ago</p>
                </div>
            </div>
            <div style="padding: 10px 15px; display: flex; align-items: flex-start;">
                <div style="background-color: #4a90e2; color: white; border-radius: 50%; width: 10px; height: 10px; margin-right: 10px; margin-top: 5px;"></div>
                <div>
                    <p style="font-size: 14px; margin-bottom: 5px;">New volunteer joined your center</p>
                    <p style="font-size: 12px; color: #999;">Yesterday</p>
                </div>
            </div>
            <div style="padding: 10px 15px; text-align: center; border-top: 1px solid #e2e8f0;">
                <a href="#" style="color: #4a90e2; text-decoration: none; font-size: 14px;">View all notifications</a>
            </div>
        `;
        
        notificationsIcon.appendChild(dropdown);
        
        // Toggle dropdown on click
        notificationsIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        });
        
        // Close dropdown when clicking elsewhere
        document.addEventListener('click', function() {
            dropdown.style.display = 'none';
        });
    }
    
    // User menu dropdown
    const userInfo = document.querySelector('.user-info');
    if (userInfo) {
        // Create dropdown element
        const dropdown = document.createElement('div');
        dropdown.className = 'user-dropdown';
        dropdown.style.display = 'none';
        dropdown.style.position = 'absolute';
        dropdown.style.right = '0';
        dropdown.style.top = '100%';
        dropdown.style.width = '200px';
        dropdown.style.backgroundColor = '#fff';
        dropdown.style.borderRadius = '8px';
        dropdown.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
        dropdown.style.zIndex = '100';
        dropdown.style.marginTop = '10px';
        
        // Add menu items
        dropdown.innerHTML = `
            <ul style="list-style: none; padding: 0;">
                <li style="padding: 10px 15px; border-bottom: 1px solid #e2e8f0;">
                    <a href="#" id="profileMenuLink" style="display: block; color: #333; text-decoration: none;">
                        <i class="fas fa-user" style="margin-right: 10px;"></i> Profile
                    </a>
                </li>
                <li style="padding: 10px 15px; border-bottom: 1px solid #e2e8f0;">
                    <a href="#" style="display: block; color: #333; text-decoration: none;">
                        <i class="fas fa-cog" style="margin-right: 10px;"></i> Settings
                    </a>
                </li>
                <li style="padding: 10px 15px;">
                    <a href="logout.php" style="display: block; color: #e74c3c; text-decoration: none;">
                        <i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i> Logout
                    </a>
                </li>
            </ul>
        `;
        
        userInfo.appendChild(dropdown);
        
        // Toggle dropdown on click
        userInfo.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        });
        
        // Close dropdown when clicking elsewhere
        document.addEventListener('click', function() {
            dropdown.style.display = 'none';
        });
        
        // Link profile menu item to profile modal
        const profileMenuLink = dropdown.querySelector('#profileMenuLink');
        profileMenuLink.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('profileModal').style.display = 'block';
            dropdown.style.display = 'none';
        });
    }
    
    // Animated counters for stats
    function animateValue(obj, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            obj.innerHTML = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }
    
    // Find all stat number elements and animate them
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        const value = parseInt(stat.textContent.replace(/[^0-9.-]+/g, ''));
        if (!isNaN(value)) {
            // Start from 0 and animate to the actual value
            stat.innerHTML = '0';
            animateValue(stat, 0, value, 1500);
        }
    });
    
    // Chart for dashboard statistics (can be uncommented if you add chart.js to your project)
    /*
    if (typeof Chart !== 'undefined') {
        const ctx = document.getElementById('adoptionChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Adoptions',
                        data: [5, 8, 12, 9, 14, 16],
                        borderColor: '#4a90e2',
                        backgroundColor: 'rgba(74, 144, 226, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }
    }
    */
    
    // Review buttons functionality
    const reviewButtons = document.querySelectorAll('.btn-primary');
    reviewButtons.forEach(button => {
        button.addEventListener('click', function() {
            // In a real application, this would navigate to the application review page
            // For now, we'll just add a simple effect
            const originalText = button.textContent;
            button.textContent = 'Loading...';
            button.disabled = true;
            
            setTimeout(() => {
                button.textContent = originalText;
                button.disabled = false;
                alert('In a real application, this would take you to the adoption application review page.');
            }, 1000);
        });
    });
    
    // Form submission prevention (for demo purposes)
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Form submission would happen here in a real application.');
        });
    });
    
    // Add tooltip functionality
    function createTooltip(element, message) {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = message;
        tooltip.style.position = 'absolute';
        tooltip.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
        tooltip.style.color = '#fff';
        tooltip.style.padding = '5px 10px';
        tooltip.style.borderRadius = '4px';
        tooltip.style.fontSize = '12px';
        tooltip.style.zIndex = '1000';
        tooltip.style.opacity = '0';
        tooltip.style.transition = 'opacity 0.3s';
        
        document.body.appendChild(tooltip);
        
        element.addEventListener('mouseenter', function() {
            const rect = element.getBoundingClientRect();
            tooltip.style.top = `${rect.top - tooltip.offsetHeight - 5}px`;
            tooltip.style.left = `${rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2)}px`;
            tooltip.style.opacity = '1';
        });
        
        element.addEventListener('mouseleave', function() {
            tooltip.style.opacity = '0';
        });
    }
    
    // Add tooltips to nav items
    const navItems = document.querySelectorAll('.main-nav li a');
    navItems.forEach(item => {
        const tooltipText = item.textContent.trim();
        if (window.innerWidth <= 992) {
            createTooltip(item, tooltipText);
        }
    });
    
    // Add date information
    function updateDateTime() {
        const dateElement = document.createElement('div');
        dateElement.className = 'current-date';
        dateElement.style.marginLeft = 'auto';
        dateElement.style.marginRight = '20px';
        dateElement.style.fontSize = '0.9rem';
        dateElement.style.color = '#666';
        
        const now = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        dateElement.textContent = now.toLocaleDateString('en-US', options);
        
        const headerElement = document.querySelector('.top-header');
        if (headerElement && !document.querySelector('.current-date')) {
            headerElement.appendChild(dateElement);
        }
    }
    
    updateDateTime();
    setInterval(updateDateTime, 60000); // Update every minute
});