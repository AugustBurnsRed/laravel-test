<table data-link="row" class="{{ $class or 'table table-striped table-bordered table-hover rowlink' }}">
    @if(count($columns))
    <thead>
        <tr>
        @foreach($columns as $c)
            <th {!! $c->getClasses() ? ' class="' . $c->getClassString() . '"' : '' !!}>
                @if($c->isSortable())
                    <a href="{{ $c->getSortURL() }}"</a>
                        {!! $c->getLabel() !!}
                        @if($c->isSorted())
                            @if($c->getDirection() == 'asc')
                                <span class="fa fa-sort-asc"></span>
                            @elseif($c->getDirection() == 'desc')
                                <span class="fa fa-sort-desc"></span>
                            @endif
                        @endif
                    </a>
                @else
                    {{ $c->getLabel() }}
                @endif
            </th>
        @endforeach

        </tr>
    </thead>
    @endif
    <tbody>
        @if(count($rows))
            @foreach($rows as $r)

        <tr>
            @foreach($columns as $c)

                <td {!! $c->getClasses() ? ' class="rowlink-skip' . $c->getClassString() . '"' : '' !!}>

                <a href="{{ action('MoviesController@show', [$r->serie_id, $r->id]) }}">

                 @if($c->hasRenderer())
                    {{-- Custom renderer applied to this column, call it now --}}
                    {!! $c->render($r) !!}
                    @else
                    {{-- Use the "rendered_foo" field, if available, else use the plain "foo" field --}}
                        {!! $r->{'rendered_' . $c->getField()} or $r->{$c->getField()} !!}
                    @endif
                    </a>


                    @if($c->getField() == 'title')
                        @if( ! empty($r->tags))
                            @foreach ($r->tags as $tag)
                                <li><a href="/torrents?tags={{ $tag->name }}">{{ $tag->name }}</a></li>
                            @endforeach
                        @endif
                    @endif

                    @if($c->getField() == 'title')
                        @if( ! empty($r->torrents))
                            @foreach ($r->torrents as $torrent)
                                <li><a href="{{ action('MoviesController@show', [$r->serie_id, $r->id]) }}">{{ $torrent->title }}</a></li>
                            @endforeach
                        @endif
                    @endif
                </td>
            @endforeach

        </tr>

            @endforeach
        @endif
    </tbody>
</table>

@if(class_basename(get_class($rows)) == 'LengthAwarePaginator')
    {{-- Collection is paginated, so render that --}}
    {!! with(new App\Steven\CustomVendor\PaginationLinks($rows))->render() !!}
@endif
