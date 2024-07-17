{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')" />
<x-backpack::menu-item title="Orders" icon="la la-file-invoice" :link="backpack_url('order')" />
<x-backpack::menu-item title="Tables" icon="la la-radiation-alt" :link="backpack_url('table')" />
<x-backpack::menu-item title="Items" icon="la la-cocktail" :link="backpack_url('item')" />
