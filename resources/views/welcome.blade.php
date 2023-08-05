@extends('template')
@section('content')

<!-- Default box -->
<div class="card">
    <div class="card-header">
        <div class="pull-left">
            <h2>DataTables</h2>
        </div>
    </div>
    <div class="card-body">
        <!-- Datatables -->
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right mb-2">
                <a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Create Company</a>
            </div>
        </div>
    </div>
    @if($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card-body">
        <table class="table table-bordered" id="ajax-crud-datatable">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
    </div>
</div>
<!-- /.card -->

<!-- LEAFLET MAP -->
<div class="card">
    <div class="card-header">
        <div class="pull-left">
            <h2>Map</h2>
        </div>
    </div>
<center>

    <link rel="stylesheet" href="{{ asset('node_modules/leaflet/dist/leaflet.css') }}" />
    <!-- <script src="{{ asset('node_modules/leaflet/dist/leaflet.js') }}"></script> -->

    <style>
        #map {
            width: 700px;
            height: 300px;
        }
    </style>
    <div id="map"></div>

    <script>
        var map = L.map('map').setView([-7.605543, -249.046605], 13);


        //circle
        var circle = L.circle([-7.605543, -249.046605], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 500
        }).addTo(map)
        circle.bindPopup("<b>Redzone!</b>");

        //polygon
        var polygon = L.polygon([
            [-7.597974, -249.065423],
            [-7.594043, -249.067376],
            [-7.591333, -249.064833],
            [-7.591716, -249.062301],
            [-7.595081, -249.057269],
            [-7.607272, -249.065144]

        ]).addTo(map).bindPopup("<b>Rawan begal</b>");

        // buat variabel berisi fungsi L.popup
        var popup = L.popup();

        // buat fungsi popup saat map diklik
        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("Koordinatnya adalah " + e.latlng.toString())
                //set isi konten yang ingin ditampilkan, kali ini kita akan menampilkan latitude dan longitude
                .openOn(map);
            document.getElementById('Asal').value = e
                .latlng //value pada form latitde, longitude akan berganti secara otomatis
        }

        map.on('click', onMapClick); //jalankan fungsi

        //menentukan jenis petanya (basemap)
        L.tileLayer(
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibmFiaWxjaGVuIiwiYSI6ImNrOWZzeXh5bzA1eTQzZGxpZTQ0cjIxZ2UifQ.1YMI-9pZhxALpQ_7x2MxHw', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 20,
                id: 'mapbox/streets-v11', //menggunakan peta model streets-v11 kalian bisa melihat jenis-jenis peta lainnnya di web resmi mapbox
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'your.mapbox.access.token'
            }).addTo(map);

        //bike lanes
        L.tileLayer('http://tiles.mapc.org/trailmap-onroad/{z}/{x}/{y}.png', {
            maxZoom: 17,
            minZoom: 9
        }).addTo(map);

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 17,
            minZoom: 9
        }).addTo(map);


        // needed token
        //     ACCESS_TOKEN = 'pk.eyJ1IjoibWFwYm94IiwiYSI6IjZjNmRjNzk3ZmE2MTcwOTEwMGY0MzU3YjUzOWFmNWZhIn0.Y8bhBaUMqFiPrDRW9hieoQ';
        // ACCESS_TOKEN = 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpandmbXliNDBjZWd2M2x6bDk3c2ZtOTkifQ._QA7i5Mpkd_m30IGElHziw';
        //     L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + ACCESS_TOKEN, {
        //         attribution: 'Imagery © <a href="http://mapbox.com">Mapbox</a>',
        //         id: 'mapbox.streets'
        //     }).addTo(map); 
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/map.js') }}" defer></script>
</center>
</div>

<!-- Boostrap Company Model -->
<div class="modal fade" id="company-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="CompanyModal"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="CompanyForm" name="CompanyForm" class="form-horizontal"
                    method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Company Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Company Name" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Company Email</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter Company Email" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Company Address</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="Enter Company Address" required="">
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save">Save changes
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- End Bootstrap Model -->

@endsection