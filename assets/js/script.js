// Funcionalidad para las pestañas
document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad de pestañas
    const tabs = document.querySelectorAll('.tab');
    if (tabs.length > 0) {
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab
                tab.classList.add('active');
                
                // Show corresponding content
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(`${tabId}Tab`).classList.add('active');
            });
        });
    }
    
    // Funcionalidad del modal
    const addRecreoBtn = document.getElementById('addRecreoBtn');
    const addRecreoModal = document.getElementById('addRecreoModal');
    const modalClose = document.querySelector('.modal-close');
    
    if (addRecreoBtn && addRecreoModal) {
        addRecreoBtn.addEventListener('click', () => {
            addRecreoModal.style.display = 'flex';
        });
        
        modalClose.addEventListener('click', () => {
            addRecreoModal.style.display = 'none';
        });
        
        window.addEventListener('click', (e) => {
            if (e.target === addRecreoModal) {
                addRecreoModal.style.display = 'none';
            }
        });
    }
});