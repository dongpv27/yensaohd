// Header dropdown functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all dropdowns
    var dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        var dropdown = new bootstrap.Dropdown(dropdownToggleEl, {
            autoClose: true
        });
        
        // Manual toggle for better control
        dropdownToggleEl.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Dropdown clicked:', dropdownToggleEl);
            
            // Find the associated menu
            var menu = dropdownToggleEl.nextElementSibling;
            if (!menu) {
                menu = document.querySelector('[aria-labelledby="' + dropdownToggleEl.id + '"]');
            }
            
            if (menu) {
                console.log('Menu found:', menu);
                console.log('Current classes:', menu.className);
                
                if (menu.classList.contains('show')) {
                    menu.classList.remove('show');
                    dropdownToggleEl.setAttribute('aria-expanded', 'false');
                } else {
                    // Close all other dropdowns first
                    document.querySelectorAll('.dropdown-menu.show').forEach(function(m) {
                        m.classList.remove('show');
                    });
                    
                    menu.classList.add('show');
                    dropdownToggleEl.setAttribute('aria-expanded', 'true');
                    console.log('Added show class');
                }
            } else {
                console.log('Menu not found!');
            }
        });
        
        return dropdown;
    });
    
    console.log('Dropdowns initialized:', dropdownList.length);
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                menu.classList.remove('show');
            });
        }
    });
});

// Header scroll effects
let lastScroll = 0;

window.addEventListener('DOMContentLoaded', function() {
    const header = document.getElementById('mainHeader');
    
    if (!header) {
        console.warn('Header element not found');
        return;
    }
    
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        // Add shadow when scrolled
        if (currentScroll > 0) {
            header.classList.add('shadow-header');
        } else {
            header.classList.remove('shadow-header');
        }
        
        // Hide navigation bar when scrolling down (keep topbar visible)
        if (currentScroll > 100) {
            header.classList.add('header-scrolled');
        } else {
            header.classList.remove('header-scrolled');
        }
        
        lastScroll = currentScroll;
    });
});
