@extends('layouts.app')

@section('content')
    <div class="card">
        <h2 style="margin-top:0;">{{ __('ui.analytics.title') }}</h2>
        <p style="margin:6px 0 0;color:#94a3b8;">
            {{ __('ui.analytics.range') }}: {{ $start->format('d.m.Y') }} – {{ $end->format('d.m.Y') }}
        </p>
        <form method="GET" action="{{ route('admin.analytics.index') }}" style="margin-top:14px;display:flex;flex-wrap:wrap;gap:12px;align-items:end;">
            <div class="form-group" style="margin:0;">
                <label>{{ __('ui.analytics.from') }}</label>
                <input type="date" name="from" value="{{ $start->format('Y-m-d') }}">
            </div>
            <div class="form-group" style="margin:0;">
                <label>{{ __('ui.analytics.to') }}</label>
                <input type="date" name="to" value="{{ $end->format('Y-m-d') }}">
            </div>
            <button class="btn" type="submit">{{ __('ui.analytics.apply') }}</button>
            <a class="btn btn-secondary" href="{{ route('admin.analytics.index') }}">{{ __('ui.common.reset') }}</a>
        </form>
    </div>

    <div class="grid grid-3">
        <div class="card">
            <strong style="font-size:28px;display:block;">{{ $totalVisits }}</strong>
            <span style="color:#94a3b8;">{{ __('ui.analytics.total_visits') }}</span>
        </div>
        <div class="card">
            <strong style="font-size:28px;display:block;">{{ $sources->first()->total ?? 0 }}</strong>
            <span style="color:#94a3b8;">{{ __('ui.analytics.top_source') }}: {{ $sources->first()->source ?? '—' }}</span>
        </div>
        <div class="card">
            <strong style="font-size:28px;display:block;">{{ $topPages->first()->total ?? 0 }}</strong>
            <span style="color:#94a3b8;">{{ __('ui.analytics.top_page') }}: {{ $topPages->first()->path ?? '—' }}</span>
        </div>
    </div>

    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
        <div class="card">
            <h3 style="margin-top:0;">{{ __('ui.analytics.daily_visits') }}</h3>
            @if($dailyVisits->isEmpty())
                <p style="color:#94a3b8;">{{ __('ui.analytics.empty') }}</p>
            @else
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach($dailyVisits as $row)
                        <div style="display:flex;align-items:center;gap:12px;">
                            <span style="width:86px;flex-shrink:0;color:#94a3b8;">{{ \Carbon\Carbon::parse($row->date)->format('d.m.') }}</span>
                            <div style="flex:1;background:#0f172a;border-radius:999px;overflow:hidden;">
                                <div style="height:10px;background:#38bdf8;width:{{ min(100, ($row->total / max(1, $dailyVisits->max('total'))) * 100) }}%;"></div>
                            </div>
                            <strong style="width:40px;text-align:right;">{{ $row->total }}</strong>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="card">
            <h3 style="margin-top:0;">{{ __('ui.analytics.sources') }}</h3>
            @if($sources->isEmpty())
                <p style="color:#94a3b8;">{{ __('ui.analytics.empty') }}</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('ui.analytics.table.source') }}</th>
                            <th>{{ __('ui.analytics.table.visits') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sources as $source)
                            <tr>
                                <td>{{ $source->source }}</td>
                                <td>{{ $source->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="card">
            <h3 style="margin-top:0;">{{ __('ui.analytics.top_pages') }}</h3>
            @if($topPages->isEmpty())
                <p style="color:#94a3b8;">{{ __('ui.analytics.empty') }}</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('ui.analytics.table.path') }}</th>
                            <th>{{ __('ui.analytics.table.visits') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topPages as $page)
                            <tr>
                                <td>{{ $page->path }}</td>
                                <td>{{ $page->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
