@php 
    use Illuminate\Support\Facades\Auth; 
    use Illuminate\Support\Facades\Route;
@endphp

<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <!-- Logo atau Brand bisa ditambahkan di sini -->
                </div>

                <ul class="navbar-nav header-right">
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <div class="user-profile d-flex align-items-center">
                                <i class="mdi mdi-account-circle profile-icon"></i>
                                <span class="ml-2 d-none d-sm-inline">{{ auth()->user()->name }}</span>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                            <div class="dropdown-header text-center">
                                <div class="user-avatar mb-3">
                                    <i class="mdi mdi-account-circle"></i>
                                </div>
                                <h5 class="user-name mb-2">{{ auth()->user()->name }}</h5>
                                <div class="user-email mb-2">{{ auth()->user()->email }}</div>
                                <div class="user-level">{{ ucfirst(auth()->user()->level) }}</div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout mr-2"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<style>
    .header {
        background: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 0.5rem 1rem;
    }
    
    .user-profile {
        padding: 0.5rem;
    }
    
    .profile-icon {
        font-size: 1.8rem !important;
        color: #4e73df;
    }
    
    .profile-dropdown {
        min-width: 280px;
        padding: 0;
    }
    
    .dropdown-header {
        padding: 1.5rem;
        background: #f8f9fc;
        border-radius: 0.35rem 0.35rem 0 0;
    }
    
    .user-avatar {
        font-size: 3.5rem;
        color: #4e73df;
        margin-bottom: 1rem;
    }
    
    .user-name {
        font-size: 1.15rem;
        font-weight: 600;
        color: #2e3555;
        margin-bottom: 0.5rem;
    }
    
    .user-email {
        font-size: 0.95rem;
        color: #666;
        margin-bottom: 0.5rem;
    }
    
    .user-level {
        display: inline-block;
        padding: 0.35em 0.8em;
        font-size: 0.95rem;
        font-weight: 500;
        background: #4e73df;
        color: #fff;
        border-radius: 0.25rem;
    }
    
    .dropdown-item {
        padding: 0.8rem 1.5rem;
        display: flex;
        align-items: center;
        color: #3a3b45;
        transition: all 0.2s;
    }
    
    .dropdown-item:hover {
        background: #f8f9fc;
        color: #4e73df;
    }
    
    .dropdown-item i {
        font-size: 1.1rem;
    }
</style>