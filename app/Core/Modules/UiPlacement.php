<?php

/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/UiPlacement.php
| Purpose: Declares approved placement targets for module UI entries.
|--------------------------------------------------------------------------
*/

namespace App\Core\Modules;


enum UiPlacement: string
{
    case AreaNavigation = 'area_navigation';
    case HeaderGlobalActions = 'header_global_actions';
    case AccountMenu = 'account_menu';
    case SettingsSidebar = 'settings_sidebar';
    case PreferencesNavigation = 'preferences_navigation';
    case SetupNavigation = 'setup_navigation';
    case Dashboard = 'dashboard';
    case Main = 'main';
    case Extension = 'extension';
}
