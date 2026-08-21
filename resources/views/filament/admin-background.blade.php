

<style>
    body.fi-body {
        background-image: url('{{ asset("images/background.png") }}') !important;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
    }

    /* Card backgrounds: soft light blue -- scoped only to actual card
       containers, not every white element (that broader rule was
       accidentally tinting icon badges too). */
    .fi-wi-stats-overview-stat,
    .fi-section {
        background-color: #E6F1FB !important;
    }

    .fi-sidebar {
        background-color: #0072CE !important;
    }
    /*.fi-sidebar a,*/
    /*.fi-sidebar-item-label,*/
    /*.fi-sidebar-nav-item-label {*/
    /*    color: #ffffff !important;*/
    /*}*/
    /*.fi-sidebar svg {*/
    /*    color: #ffffff !important;*/
    /*}*/

    /*.fi-sidebar-item-active,*/
    /*.fi-active {*/
    /*    background-color: rgba(255,255,255,0.18) !important;*/
    /*    border-radius: 8px;*/
    /*}*/

    /*.fi-sidebar-item a:hover,*/
    /*.fi-sidebar-nav-item a:hover {*/
    /*    background-color: rgba(255,255,255,0.12) !important;*/
    /*    border-radius: 8px;*/
    /*}*/

    .fi-topbar nav {
        display: flex;
        align-items: center;
        position: relative;
    }
    .fi-global-search {
        position: absolute !important;
        left: 60px;
        top: 50%;
        transform: translateY(-50%);
        width: 320px;
    }

    /* Colours the icon + label text on each of the 4 dashboard KPI
       cards, matching the order they're returned in
       GuidePortalStatsOverview.php (1st = Total guides, and so on). */
    .fi-wi-stats-overview-stats-ctn > div:nth-child(1) .fi-wi-stats-overview-stat-icon,
    .fi-wi-stats-overview-stats-ctn > div:nth-child(1) .fi-wi-stats-overview-stat-label {
        color: #002395 !important;
    }
    .fi-wi-stats-overview-stats-ctn > div:nth-child(2) .fi-wi-stats-overview-stat-icon,
    .fi-wi-stats-overview-stats-ctn > div:nth-child(2) .fi-wi-stats-overview-stat-label {
        color: #007A4D !important;
    }
    .fi-wi-stats-overview-stats-ctn > div:nth-child(3) .fi-wi-stats-overview-stat-icon,
    .fi-wi-stats-overview-stats-ctn > div:nth-child(3) .fi-wi-stats-overview-stat-label {
        color: #4EA8DE !important;
    }
    .fi-wi-stats-overview-stats-ctn > div:nth-child(4) .fi-wi-stats-overview-stat-icon,
    .fi-wi-stats-overview-stats-ctn > div:nth-child(4) .fi-wi-stats-overview-stat-label {
        color: #0B1F3A !important;
    }
</style>















{{--<style>--}}
{{--    body.fi-body {--}}
{{--        background-image: url('{{ asset("images/background.png") }}') !important;--}}
{{--        background-size: cover;--}}
{{--        background-position: center;--}}
{{--        background-attachment: fixed;--}}
{{--        background-repeat: no-repeat;--}}
{{--    }--}}
{{--    .fi-main .bg-white {--}}
{{--        background-color: #E6F1FB !important;--}}
{{--    }--}}

{{--    /* Sidebar: solid blue,  */--}}
{{--    .fi-sidebar {--}}
{{--        background-color: #0072CE !important;--}}
{{--    }--}}

{{--    /* Sidebar links and icons: white writing instead of blue */--}}
{{--    .fi-sidebar a,--}}
{{--    .fi-sidebar-item-label,--}}
{{--    .fi-sidebar-nav-item-label {--}}
{{--        color: #ffffff !important;--}}
{{--    }--}}
{{--    .fi-sidebar svg {--}}
{{--        color: #ffffff !important;--}}
{{--    }--}}

{{--    /* The current page you're on gets a soft white highlight,--}}
{{--       instead of an orange one -- this replaces the old highlight--}}
{{--       colour now that the sidebar itself is blue. */--}}
{{--    .fi-sidebar-item-active,--}}
{{--    .fi-active {--}}
{{--        background-color: rgba(255,255,255,0.18) !important;--}}
{{--        border-radius: 8px;--}}
{{--    }--}}
{{--    /* Pushes the search box to sit on the left side of the top bar */--}}
{{--    .fi-topbar nav {--}}
{{--        display: flex;--}}
{{--        align-items: center;--}}
{{--    }--}}
{{--    .fi-global-search-field-ctn {--}}
{{--        order: -1;--}}
{{--        margin-right: auto;--}}
{{--        margin-left: 4px;--}}
{{--    }--}}
{{--</style>--}}



















{{--<style>--}}
{{--    body.fi-body {--}}
{{--        background-image: url('{{ asset("images/background.png") }}') !important;--}}
{{--        background-size: cover;--}}
{{--        background-position: center;--}}
{{--        background-attachment: fixed;--}}
{{--        background-repeat: no-repeat;--}}
{{--    }--}}
{{--    .fi-main, .fi-layout, .fi-page {--}}
{{--        background: transparent !important;--}}
{{--    }--}}
{{--</style>--}}
