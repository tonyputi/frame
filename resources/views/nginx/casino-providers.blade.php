@foreach($collection as $resource)
@if($resource->hostname)
location ^~ /diamondbet/soap/{{ $resource->name }} {
    auth_basic off;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_redirect off;

    proxy_pass https://{{ $resource->hostname ?? 'hostname' }}/diamondbet/soap/{{ $resource->name }};
}
@endif
@endforeach