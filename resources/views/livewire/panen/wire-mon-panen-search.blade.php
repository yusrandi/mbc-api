<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Filter Pencarian</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="py-1">
            <div class="form-group">
                <label>Tanggal</label>
                <div wire:ignore class="input-group date mb-2" id="appointmentDateStart" data-target-input="nearest"
                    data-appointmentdatestart="@this">
                    <input type="text" class="form-control datetimepicker-input" data-target="#appointmentDateStart"
                        id="appointmentDateStartInput" data-toggle="datetimepicker" placeholder="Start Date">

                </div>
                <div wire:ignore class="input-group date" id="appointmentDateEnd" data-target-input="nearest"
                    data-appointmentdateend="@this">
                    <input type="text" class="form-control datetimepicker-input" data-target="#appointmentDateEnd"
                        id="appointmentDateEndInput" data-toggle="datetimepicker" placeholder="Date To">

                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Panen Ke - <span class="text-danger">*</span></label>
                <select class="custom-select" wire:model="frekPanen">
                    <option value="">Pilih Panen Ke - </option>
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>

                </select>

            </div>
            <div class="form-group">
                <label class="form-label">Keterangan Panen <span class="text-danger">*</span></label>
                <select class="custom-select" wire:model="ketPanen">
                    <option value="">Pilih Keterangan Panen </option>
                    <option value="Jual"> Jual </option>
                    <option value="Beli"> Beli </option>
                </select>

            </div>
            <div class="form-group">
                <select class="custom-select" wire:model="sapiId">
                    <option value="">Pilih Sapi</option>
                    @foreach ($sapis as $item)
                        <option value="{{ $item->id }}">
                            {{ 'MBC-' . $item->generasi . '.' . $item->anak_ke . '-' . $item->eartag_induk . '-' . $item->eartag }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select class="custom-select" wire:model="peternakId">
                    <option value="">Pilih Peternak</option>
                    @foreach ($peternaks as $item)
                        <option value="{{ $item->id }}"> {{ $item->nama_peternak }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select class="custom-select" wire:model="pendampingId">
                    <option value="">Pilih Pendamping</option>
                    @foreach ($pendampings as $item)
                        <option value="{{ $item->id }}"> {{ $item->user->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select class="custom-select" wire:model="tsrId">
                    <option value="">Pilih TSR</option>
                    @foreach ($tsrs as $item)
                        <option value="{{ $item->id }}"> {{ $item->user->name }} </option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col d-flex justify-content-end">
                <button wire:click="submit" class="btn btn-primary" type="submit">Submit</button>
            </div>
        </div>
    </div>
</div>
