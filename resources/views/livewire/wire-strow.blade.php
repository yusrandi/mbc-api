<div class="row">
    <div class="col-xl-3 col-lg-4">

        <div class="card">
            <div class="card-header">
                <div class="card-title">Tambah Straw</div>
            </div>
            <div class="card-body">
                <div class="text-center mb-5">
                    <div class="widget-user-image">
                        <img alt="User Avatar" class="rounded-circle  mr-3"
                            src="{{ URL::asset('assets/images/users/2.jpg') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Pilih Sapi<span class="text-danger">*</span></label>
                    <select class="custom-select" wire:model="sapi_id">
                        <option value="">Please Choose</option>
                        @foreach ($sapis as $item)
                            <option value="{{ $item->id }}">
                                {{ 'MBC-' . $item->generasi . '.' . $item->anak_ke . '-' . $item->eartag_induk . '-' . $item->eartag }}
                            </option>
                        @endforeach
                    </select>
                    @error('sapi_id')
                        <small class="mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Kode Batch<span class="text-danger">*</span></label>
                    <input wire:model="kode_batch" type="text" class="form-control" placeholder="e.g: 9382/HK/TUY89">
                    @error('kode_batch')
                        <small class="mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Batch<span class="text-danger">*</span></label>
                    <input wire:model="batch" type="text" class="form-control" placeholder="e.g: Jatinegoro">
                    @error('batch')
                        <small class="mt-2 text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="dimmer active" style="height: 5px; margin-top: 0;" wire:loading>
                    <div class="spinner4">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button wire:click="save" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="col">
                    <div class="card-title">Tabel Straw Sapi</div>

                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">

                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select class="custom-select" wire:model="sapiId">
                                <option value="">Please Choose</option>
                                @foreach ($sapis as $item)
                                    <option value="{{ $item->id }}">
                                        {{ 'MBC-' . $item->generasi . '.' . $item->anak_ke . '-' . $item->eartag_induk . '-' . $item->eartag }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input wire:model="searchTerm" type="search" class="form-control" placeholder="Search…"
                                aria-label="Search">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover card-table table-vcenter text-nowrap">

                        @if (count($strows) != 0)
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sapi</th>
                                    <th>Kode Batch</th>
                                    <th>Batch</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($strows as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->sapi_id ? 'MBC-' . $item->sapi->generasi . '.' . $item->sapi->anak_ke . '-' . $item->sapi->eartag_induk . '-' . $item->sapi->eartag : '-' }}
                                        </td>
                                        <td>{{ $item->kode_batch }}</td>
                                        <td>{{ $item->batch }}</td>

                                        <td class="text-right">
                                            <i wire:click="selectedItem({{ $item->id }},'update')"
                                                class="fe fe-edit f-16 btn btn-success" style="cursor:pointer"></i>
                                            <i wire:click="selectedItem({{ $item->id }},'delete')"
                                                class="fe fe-trash-2 f-16 btn btn-danger" style="cursor:pointer"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            There no Data Yet
                        @endif



                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
