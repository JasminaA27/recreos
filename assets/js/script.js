// assets/js/dashboard.js

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar AOS (Animate On Scroll)
    AOS.init({
        duration: 600,
        easing: 'ease-out-cubic',
        once: true,
        offset: 100
    });

    // Funcionalidad de búsqueda
    initializeSearch();
    
    // Animaciones de las tarjetas de estadísticas
    animateStatNumbers();
    
    // Efectos hover mejorados
    initializeHoverEffects();
    
    // Funcionalidad del sidebar
    initializeSidebar();
    
    // Auto-refresh de datos (opcional)
    // initializeAutoRefresh();
});

// Función de búsqueda en tiempo real
function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            // Agregar efecto visual mientras se busca
            this.parentElement.classList.add('searching');
            
            searchTimeout = setTimeout(() => {
                if (query.length > 2) {
                    performSearch(query);
                } else {
                    clearSearchResults();
                }
                this.parentElement.classList.remove('searching');
            }, 300);
        });
        
        // Agregar efecto de focus
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    }
}

// Función para realizar búsqueda (puedes conectarla con tu backend)
function performSearch(query) {
    console.log('Buscando:', query);
    
    // Aquí puedes agregar la lógica para filtrar recreos
    const activityItems = document.querySelectorAll('.activity-item');
    
    activityItems.forEach(item => {
        const nombre = item.querySelector('h4').textContent.toLowerCase();
        const direccion = item.querySelector('p').textContent.toLowerCase();
        
        if (nombre.includes(query.toLowerCase()) || direccion.includes(query.toLowerCase())) {
            item.style.display = 'flex';
            item.classList.add('search-highlight');
        } else {
            item.style.display = 'none';
        }
    });
}

// Función para limpiar resultados de búsqueda
function clearSearchResults() {
    const activityItems = document.querySelectorAll('.activity-item');
    
    activityItems.forEach(item => {
        item.style.display = 'flex';
        item.classList.remove('search-highlight');
    });
}

// Animación de números en las estadísticas
function animateStatNumbers() {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    statNumbers.forEach(numberElement => {
        const finalNumber = parseInt(numberElement.textContent);
        let currentNumber = 0;
        const increment = finalNumber / 60; // 60 frames para la animación
        
        numberElement.textContent = '0';
        
        const timer = setInterval(() => {
            currentNumber += increment;
            if (currentNumber >= finalNumber) {
                numberElement.textContent = finalNumber;
                clearInterval(timer);
            } else {
                numberElement.textContent = Math.floor(currentNumber);
            }
        }, 25);
    });
}

// Efectos hover mejorados
function initializeHoverEffects() {
    // Efecto para tarjetas de estadísticas
    const statCards = document.querySelectorAll('.stat-card');
    
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
            this.style.boxShadow = '0 20px 40px rgba(0,0,0,0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '';
        });
    });
    
    // Efecto para items de actividad
    const activityItems = document.querySelectorAll('.activity-item');
    
    activityItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'var(--bg-color)';
            this.style.borderRadius = 'var(--radius-lg)';
            this.style.padding = '1rem';
            this.style.margin = '0 -1rem';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.borderRadius = '';
            this.style.padding = '1rem 0';
            this.style.margin = '0';
        });
    });
    
    // Efecto para acciones rápidas
    const quickActions = document.querySelectorAll('.quick-action-item');
    
    quickActions.forEach(action => {
        action.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.quick-action-icon');
            icon.style.transform = 'scale(1.1) rotate(5deg)';
        });
        
        action.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.quick-action-icon');
            icon.style.transform = 'scale(1) rotate(0deg)';
        });
    });
}

// Funcionalidad del sidebar
function initializeSidebar() {
    // Agregar indicador de página activa
    const currentPath = window.location.search;
    const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
    
    sidebarLinks.forEach(link => {
        if (link.getAttribute('href').includes(currentPath) && currentPath !== '') {
            link.parentElement.classList.add('active');
        }
    });
    
    // Efecto ripple en los enlaces del sidebar
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Crear efecto ripple
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
}

// Función para mostrar notificaciones
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        <span>${message}</span>
        <button class="notification-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove después de 5 segundos
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Función para refrescar datos automáticamente (opcional)
function initializeAutoRefresh() {
    setInterval(() => {
        // Aquí puedes agregar lógica para actualizar datos
        console.log('Actualizando datos...');
        
        // Ejemplo: actualizar estadísticas
        updateStats();
    }, 300000); // Cada 5 minutos
}

// Función para actualizar estadísticas
function updateStats() {
    // Esta función puede hacer una llamada AJAX para obtener datos actualizados
    fetch('index.php?controller=Dashboard&action=getStats')
        .then(response => response.json())
        .then(data => {
            // Actualizar los números en las tarjetas
            const statNumbers = document.querySelectorAll('.stat-number');
            if (data.total_recreos) statNumbers[0].textContent = data.total_recreos;
            if (data.ofertas_activas) statNumbers[1].textContent = data.ofertas_activas;
            if (data.recreos_huanta) statNumbers[2].textContent = data.recreos_huanta;
            if (data.recreos_luricocha) statNumbers[3].textContent = data.recreos_luricocha;
            
            showNotification('Datos actualizados', 'success');
        })
        .catch(error => {
            console.error('Error actualizando datos:', error);
        });
}

// Función para manejar clics en botones de acción
function handleActionClick(action, id) {
    switch(action) {
        case 'view':
            window.location.href = `index.php?controller=Recreo&action=view&id=${id}`;
            break;
        case 'edit':
            window.location.href = `index.php?controller=Recreo&action=edit&id=${id}`;
            break;
        case 'delete':
            if(confirm('¿Estás seguro de que deseas eliminar este recreo?')) {
                window.location.href = `index.php?controller=Recreo&action=delete&id=${id}`;
            }
            break;
    }
}

// Función para filtrar por ubicación
function filterByLocation(location) {
    const activityItems = document.querySelectorAll('.activity-item');
    
    activityItems.forEach(item => {
        const itemLocation = item.querySelector('p').textContent.toLowerCase();
        
        if (location === 'all' || itemLocation.includes(location.toLowerCase())) {
            item.style.display = 'flex';
            item.style.opacity = '1';
        } else {
            item.style.display = 'none';
            item.style.opacity = '0.5';
        }
    });
}

// Función para exportar datos
function exportData(format = 'csv') {
    showNotification('Exportando datos...', 'info');
    
    // Simular exportación
    setTimeout(() => {
        showNotification('Datos exportados exitosamente', 'success');
    }, 2000);
}

// Manejo de responsive para sidebar
function handleResponsive() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (window.innerWidth <= 768) {
        sidebar.style.transform = 'translateX(-100%)';
        mainContent.style.marginLeft = '0';
    } else {
        sidebar.style.transform = 'translateX(0)';
        mainContent.style.marginLeft = '280px';
    }
}

// Event listener para responsive
window.addEventListener('resize', handleResponsive);

// Función para toggle del sidebar en móviles
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const isOpen = sidebar.style.transform === 'translateX(0px)' || sidebar.style.transform === '';
    
    if (isOpen) {
        sidebar.style.transform = 'translateX(-100%)';
    } else {
        sidebar.style.transform = 'translateX(0)';
    }
}

// Agregar estilos CSS adicionales para las animaciones
const additionalStyles = `
<style>
/* Estilos adicionales para JavaScript */
.searching {
    position: relative;
}

.searching::after {
    content: '';
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    border: 2px solid var(--border-color);
    border-top-color: var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

.search-highlight {
    background: rgba(59, 130, 246, 0.1) !important;
    border-left: 4px solid var(--primary-color) !important;
}

.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-animation {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

.notification {
    position: fixed;
    top: 2rem;
    right: 2rem;
    background: var(--card-bg);
    color: var(--text-primary);
    padding: 1rem 1.5rem;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    z-index: 10000;
    min-width: 300px;
    animation: slideInRight 0.3s ease-out;
}

.notification-success {
    border-left: 4px solid var(--success-color);
}

.notification-error {
    border-left: 4px solid var(--danger-color);
}

.notification-info {
    border-left: 4px solid var(--primary-color);
}

.notification-close {
    background: none;
    border: none;
    color: var(--text-secondary);
    cursor: pointer;
    padding: 0.25rem;
    margin-left: auto;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Botón hamburguesa para móviles */
.mobile-menu-toggle {
    display: none;
    position: fixed;
    top: 1rem;
    left: 1rem;
    z-index: 1001;
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 0.75rem;
    border-radius: var(--radius-md);
    cursor: pointer;
}

@media (max-width: 768px) {
    .mobile-menu-toggle {
        display: block;
    }
    
    .sidebar {
        transform: translateX(-100%);
    }
    
    .sidebar.open {
        transform: translateX(0);
    }
}
</style>
`;

// Insertar estilos adicionales
document.head.insertAdjacentHTML('beforeend', additionalStyles);

// Crear botón hamburguesa para móviles
const mobileMenuToggle = document.createElement('button');
mobileMenuToggle.className = 'mobile-menu-toggle';
mobileMenuToggle.innerHTML = '<i class="fas fa-bars"></i>';
mobileMenuToggle.onclick = toggleSidebar;
document.body.appendChild(mobileMenuToggle);