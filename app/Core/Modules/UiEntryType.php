<?php

/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/UiEntryType.php
| Purpose: Declares renderable module UI entry types.
|--------------------------------------------------------------------------
*/

namespace App\Core\Modules;


enum UiEntryType: string
{
    case NavigationItem = 'navigation_item';
    case HeaderGlobalAction = 'header_global_action';
    case SettingsPage = 'settings_page';
    case PreferencePage = 'preference_page';
    case SetupScreen = 'setup_screen';
    case DashboardWidget = 'dashboard_widget';
    case MainView = 'main_view';
    case ExtensionPoint = 'extension_point';
    case ExtensionContribution = 'extension_contribution';
}
