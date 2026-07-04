<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('ticket.index') }}" class="nav-link {{ request()->is(['ticket', 'ticket/*']) ? 'active' : '' }}">
            <i class="tf-icons ti ti-tickets ti-md me-1"></i>Daftar Tiket Ajuan
        </a>
    </li>
    @hasrole('super admin')
    <li class="nav-item" role="presentation">
        <a href="{{ route('ticketcategory.index') }}" class="nav-link {{ request()->is(['ticketcategory', 'ticketcategory/*']) ? 'active' : '' }}">
            <i class="tf-icons ti ti-category ti-md me-1"></i>Master Kategori Tiket
        </a>
    </li>
    @endhasrole
</ul>
