<!-- Sidebar -->
<aside id="logo-sidebar"
    class="sidebar fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white dark:bg-gray-800"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/dashboard" id="sidebar-dashboard" class="sidebar-item">
                    <i data-feather="layout"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="" id="sidebar-users" class="sidebar-item">
                    <i data-feather="users"></i>
                    <span class="ml-3">Users</span>
                </a>
            </li>
            <li>
                <a href="{{ Route('client.index') }}" id="sidebar-clients" class="sidebar-item">
                    <i data-feather="bookmark"></i>
                    <span class="ml-3">Clients</span>
                </a>
            </li>
            <li>
                <a href="" id="sidebar-projects" class="sidebar-item">
                    <i data-feather="file"></i>
                    <span class="ml-3">Projects</span>
                </a>
            </li>
            <li>
                <a href="" id="sidebar-tasks" class="sidebar-item">
                    <i data-feather="trash"></i>
                    <span class="ml-3">Tasks</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<!-- End Sidebar -->
