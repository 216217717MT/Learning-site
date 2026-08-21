
<x-filament-panels::page>
    <div style="margin-bottom:16px;display:flex;justify-content:flex-end;">
        <div style="position:relative;">
            <select
                wire:model.live="dateRange"
                style="appearance:none;background:#0072CE;border:1px solid #0072CE;border-radius:8px;padding:8px 34px 8px 14px;font-size:13px;color:#ffffff;font-weight:600;cursor:pointer;"
            >
                <option value="all">All time</option>
                <option value="week">This week</option>
                <option value="month">This month</option>
                <option value="year">This year</option>
                <option value="today">Today</option>
            </select>

            <svg style="width:16px;height:16px;color:#ffffff;position:absolute;right:12px;top:50%;transform:translateY(-50%);pointer-events:none;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    <x-filament-widgets::widgets
        :widgets="$this->getWidgets()"
        :columns="$this->getWidgetsColumns()"
    />
</x-filament-panels::page>





{{--<x-filament-panels::page>--}}

{{--</x-filament-panels::page>--}}
