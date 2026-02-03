function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');

    sidebar.classList.toggle('show');

    if (sidebar.classList.contains('show')) {
        const backdrop = document.createElement('div');
        backdrop.className = 'sidebar-backdrop';
        backdrop.onclick = toggleSidebar;
        document.body.appendChild(backdrop);
    } else {
        document.querySelector('.sidebar-backdrop')?.remove();
    }
}
