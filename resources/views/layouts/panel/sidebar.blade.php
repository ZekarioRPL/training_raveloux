<!-- Sidebar -->
<aside id="logo-sidebar"
    class="sidebar fixed  top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-gray-800"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto">
        <ul class="space-y-2 font-medium text-white">
            <li>
                <a href="{{ Route('dashboard') }}" id="sidebar-dashboard" class="sidebar-item text-gray-500">
                    <i data-feather="layout"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            @if(auth()->user()->can('view-user'))
            <li>
                <a href="{{ Route('user.index') }}" id="sidebar-users" class="sidebar-item text-gray-500">
                    <i data-feather="users"></i>
                    <span class="ml-3">Users</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->can('view-client'))
            <li>
                <a href="{{ Route('client.index') }}" id="sidebar-clients" class="sidebar-item text-gray-500">
                    <i data-feather="bookmark"></i>
                    <span class="ml-3">Clients</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->can('view-project'))
            <li>
                <a href="{{ Route('project.index') }}" id="sidebar-projects" class="sidebar-item text-gray-500">
                    <i data-feather="file"></i>
                    <span class="ml-3">Projects</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->can('view-task'))
            <li>
                <a href="{{ Route('task.index') }}" id="sidebar-tasks" class="sidebar-item text-gray-500">
                    <i data-feather="list"></i>
                    <span class="ml-3">Tasks</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</aside>
<!-- End Sidebar -->
