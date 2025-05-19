@extends('layout.main')
@section('title', 'Contact')
@section('judul')
Contact
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Form Contact</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if($contact)
                <form action="{{ route('admin.contactupdate', $contact->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Form Contact</h3>
                                </div>
                                <div class="card-body">
                                    <!-- WhatsApp -->
                                    <div class="form-group">
                                        <label for="inputWhatsapp">WhatsApp</label>
                                        <small>(wajib berupa angka)</small>
                                        <input type="tel" pattern="[0-9]{10,15}" class="form-control" id="inputWhatsapp" name="whatsapp" placeholder="Enter Nomor WhatsApp" value="{{ old('whatsapp', $contact->whatsapp ?? '') }}">
                                        @error('whatsapp')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- WhatsApp URL -->
                                    <div class="form-group">
                                        <label for="inputWhatsappURL">URL WhatsApp</label>
                                        <input type="url" class="form-control" id="inputWhatsappURL" name="whatsapp_url" placeholder="Enter WhatsApp URL" value="{{ old('whatsapp_url', $contact->whatsapp_url ?? '') }}">
                                        @error('whatsapp_url')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    
                                    <!-- Email -->
                                    <div class="form-group">
                                        <label for="inputEmail">Email</label>
                                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Enter Email" value="{{ old('email', $contact->email ?? '') }}">
                                        @error('email')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Email URL -->
                                    <div class="form-group">
                                        <label for="inputEmailURL">URL Email</label>
                                        <input type="url" class="form-control" id="inputEmailURL" name="email_url" placeholder="Enter Email URL" value="{{ old('email_url', $contact->email_url ?? '') }}">
                                        @error('email_url')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <p>No contact data available.</p>
            @endif
        </div>
    </section>
</div>

<script>
    document.getElementById('inputWhatsapp').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    });
</script>
@endsection
