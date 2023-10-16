@foreach ($menus = DashboardMenu::getAll() as $menu)
    @php $menu = apply_filters(BASE_FILTER_DASHBOARD_MENU, $menu); @endphp
    <li class="nav-item @if ($menu['active']) active @endif" id="{{ $menu['id'] }}">
        <a href="{{ $menu['url'] }}" class="nav-link nav-toggle">
            <i class="{{ $menu['icon'] }}"></i>
            <span class="title">
                {{ !is_array(trans($menu['name'])) ? trans($menu['name']) : null }}
                {!! apply_filters(BASE_FILTER_APPEND_MENU_NAME, null, $menu['id']) !!}</span>
            @if (isset($menu['children']) && count($menu['children'])) <span class="arrow @if ($menu['active']) open @endif"></span> @endif
        </a>
        @if (isset($menu['children']) && count($menu['children']))
            <ul class="sub-menu @if (!$menu['active']) hidden-ul @endif">
                @foreach ($menu['children'] as $item)
                    <li class="nav-item @if ($item['active']) active @endif" id="{{ $item['id'] }}">
                        <a href="{{ $item['url'] }}" class="nav-link">
                            <i class="{{ $item['icon'] }}"></i>
                            {{ trans($item['name']) }}
                            {!! apply_filters(BASE_FILTER_APPEND_MENU_NAME, null, $item['id']) !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach
<li class="nav-item " id="cms-plugin-translation">
    <a href="http://127.0.0.1:8000/admin/translations/admin" class="nav-link nav-toggle">
        <i class="fas fa-mail-bulk"></i>
        <span class="title">
                Mails
                </span>
        <span class="arrow "></span>         </a>
    <ul class="sub-menu hidden-ul">
        <li class="nav-item">
            <a href="{{ route('admin.emails.normal.index') }}" class="nav-link">impostazione e-mail normale</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.emails.pec.index') }}" class="nav-link">inviare e-mail normale</a>
        </li>
    </ul>
</li>
