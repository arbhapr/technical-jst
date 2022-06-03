@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Employee List</div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->all())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach($errors->all() as $message)
                            <li>{{$message}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <button class="btn btn-primary btn-md" id="btn-create" data-target="#createModal"
                        data-toggle="modal">Add
                        Employee</button>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered w-100 mt-3 dataTable">
                            <thead class="thead-dark bg-primary text-light">
                                <tr>
                                    <td>Name</td>
                                    <td>Phone</td>
                                    <td>D.O.B</td>
                                    <td>Address</td>
                                    <td>Current Position</td>
                                    <td>KTP Files</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if($emps->all())
                                @foreach($emps as $n => $item)
                                <tr>
                                    <td>{{ $item->getFullName() }}</td>
                                    <td>{{ $item->phone_number }}</td>
                                    <td>{{ $item->date_of_birth ? date('d F Y', strtotime($item->date_of_birth)) : '-' }}
                                    </td>
                                    <td>{{ $item->street_address ?? '-' }}</td>
                                    <td>{{ $item->current_position ? ucwords($item->current_position) : '-' }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm btn-ktp"
                                            data-file="{{ $item->ktp_files }}">View</button>
                                    </td>
                                    <td>
                                        <form action="{{ route('employees.destroy', $item->id) }}" method="post">
                                            <button class="btn btn-warning btn-sm btn-edit" type="button"
                                                data-id="{{ $item->id }}">Edit</button>
                                            <input class="btn btn-sm btn-danger" type="submit" value="Delete" />
                                            @method('delete')
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7" class="text-center">No Data</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add New Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="firstNameField">
                                        First Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="first_name"
                                        value="{{ old('first_name') }}" id="firstNameField" placeholder="e.g John"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="lastNameField">
                                        Last Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ old('last_name') }}" id="lastNameField" placeholder="e.g Doe"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="phoneNumberField">
                                        Phone Number
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control" name="phone_number"
                                        value="{{ old('phone_number') }}" id="phoneNumberField" placeholder="+62"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="ktpNumberField">
                                        KTP Number
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control" name="ktp_number"
                                        value="{{ old('ktp_number') }}" id="ktpNumberField" placeholder="e.g 327XXXX001"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="scanOfKTPField">
                                        Scan of KTP
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" accept=".jpg,.jpeg,.png" class="form-control" name="ktp_files"
                                        value="{{ old('ktp_files') }}" id="scanOfKTPField" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="emailField">
                                        Email
                                    </label>
                                    <input type="email" class="form-control" name="email_address"
                                        value="{{ old('email_address') }}" id="emailField"
                                        placeholder="e.g john.doe@gmail.com">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="dobField">
                                        Date of Birth
                                    </label>
                                    <input type="date" max="{{ date('Y-m-d') }}" class="form-control"
                                        name="date_of_birth" value="{{ old('date_of_birth') }}" id="dobField"
                                        placeholder="e.g 01/01/1999">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="currentPositionField">
                                        Current Position
                                    </label>
                                    <select name="current_position" id="currentPositionField" class="form-control">
                                        <option value="" disabled selected>Select Current Position</option>
                                        <option value="staff">Staff</option>
                                        <option value="supervisor">Supervisor</option>
                                        <option value="ast. manager">Ast. Manager</option>
                                        <option value="manager">Manager</option>
                                        <option value="vice director">Vice Director</option>
                                        <option value="director">Director</option>
                                        <option value="bod">BOD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="bankAccountField">
                                        Bank Account
                                    </label>
                                    <select name="bank_account" id="bankAccountField" class="form-control">
                                        <option value="" disabled selected>Select Bank Account</option>
                                        <option value="BCA">BCA</option>
                                        <option value="BNI">BNI</option>
                                        <option value="BRI">BRI</option>
                                        <option value="BTN">BTN</option>
                                        <option value="CIMB">CIMB</option>
                                        <option value="Mandiri">Mandiri</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="bankAccountNumberField">
                                        Bank Account Number
                                    </label>
                                    <input type="number" class="form-control" name="bank_account_number"
                                        value="{{ old('bank_account_number') }}" id="bankAccountNumberField"
                                        placeholder="e.g 454XXX">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="provinceField">
                                        Province Address
                                    </label>
                                    <select name="province_address" id="provinceField" class="form-control">
                                        <option value="" disabled selected>Select Province</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="cityField">
                                        City Address
                                    </label>
                                    <select name="city_address" id="cityField" class="form-control">
                                        <option value="" disabled selected>Select City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="zipCodeField">
                                        Zip Code
                                    </label>
                                    <input type="text" class="form-control" name="zip_code"
                                        value="{{ old('zip_code') }}" id="zipCodeField" placeholder="e.g 14045">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="streetAddressField">
                                        Street Address
                                    </label>
                                    <textarea type="text" class="form-control" name="street_address"
                                        id="streetAddressField" placeholder="e.g Hogwarts Street" rows="3"
                                        style="resize: horizontal;">{{ old('street_address') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-cancel" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit New Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-update" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="firstNameFieldEdit">
                                        First Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="first_name"
                                        value="{{ old('first_name') }}" id="firstNameFieldEdit" placeholder="e.g John"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="lastNameFieldEdit">
                                        Last Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ old('last_name') }}" id="lastNameFieldEdit" placeholder="e.g Doe"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="phoneNumberFieldEdit">
                                        Phone Number
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control" name="phone_number"
                                        value="{{ old('phone_number') }}" id="phoneNumberFieldEdit" placeholder="+62"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="ktpNumberFieldEdit">
                                        KTP Number
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control" name="ktp_number"
                                        value="{{ old('ktp_number') }}" id="ktpNumberFieldEdit"
                                        placeholder="e.g 327XXXX001" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="scanOfKTPFieldEdit">
                                        Scan of KTP
                                    </label>
                                    <input type="file" accept=".jpg,.jpeg,.png" class="form-control" name="ktp_files"
                                        value="{{ old('ktp_files') }}" id="scanOfKTPFieldEdit">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="emailFieldEdit">
                                        Email
                                    </label>
                                    <input type="email" class="form-control" name="email_address"
                                        value="{{ old('email_address') }}" id="emailFieldEdit"
                                        placeholder="e.g john.doe@gmail.com">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="dobFieldEdit">
                                        Date of Birth
                                    </label>
                                    <input type="date" max="{{ date('Y-m-d') }}" class="form-control"
                                        name="date_of_birth" value="{{ old('date_of_birth') }}" id="dobFieldEdit"
                                        placeholder="e.g 01/01/1999">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="currentPositionFieldEdit">
                                        Current Position
                                    </label>
                                    <select name="current_position" id="currentPositionFieldEdit" class="form-control">
                                        <option value="" disabled selected>Select Current Position</option>
                                        <option value="staff">Staff</option>
                                        <option value="supervisor">Supervisor</option>
                                        <option value="ast. manager">Ast. Manager</option>
                                        <option value="manager">Manager</option>
                                        <option value="vice director">Vice Director</option>
                                        <option value="director">Director</option>
                                        <option value="bod">BOD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="bankAccountFieldEdit">
                                        Bank Account
                                    </label>
                                    <select name="bank_account" id="bankAccountFieldEdit" class="form-control">
                                        <option value="" disabled selected>Select Bank Account</option>
                                        <option value="BCA">BCA</option>
                                        <option value="BNI">BNI</option>
                                        <option value="BRI">BRI</option>
                                        <option value="BTN">BTN</option>
                                        <option value="CIMB">CIMB</option>
                                        <option value="Mandiri">Mandiri</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="bankAccountNumberFieldEdit">
                                        Bank Account Number
                                    </label>
                                    <input type="number" class="form-control" name="bank_account_number"
                                        value="{{ old('bank_account_number') }}" id="bankAccountNumberFieldEdit"
                                        placeholder="e.g 454XXX">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="provinceFieldEdit">
                                        Province Address
                                    </label>
                                    <select name="province_address" id="provinceFieldEdit" class="form-control">
                                        <option value="" disabled selected>Select Province</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="cityFieldEdit">
                                        City Address
                                    </label>
                                    <select name="city_address" id="cityFieldEdit" class="form-control">
                                        <option value="" disabled selected>Select City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="zipCodeFieldEdit">
                                        Zip Code
                                    </label>
                                    <input type="text" class="form-control" name="zip_code"
                                        value="{{ old('zip_code') }}" id="zipCodeFieldEdit" placeholder="e.g 14045">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="streetAddressFieldEdit">
                                        Street Address
                                    </label>
                                    <textarea type="text" class="form-control" name="street_address"
                                        id="streetAddressFieldEdit" placeholder="e.g Hogwarts Street" rows="3"
                                        style="resize: horizontal;">{{ old('street_address') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-cancel" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="showKTP" tabindex="-1" role="dialog" aria-labelledby="showKTPLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showKTPLabel">KTP Files</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="" alt="" id="previewKTP" style="width: 30%;">
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".dataTable").DataTable();

        // Create
        $("#btn-create").on('click', function () {
            $.ajax({
                url: baseUrl + "/employees/jsonProvinces",
                type: 'GET',
                dataType: 'json',
                success: function (rs) {
                    $.each(rs.data, function (i, item) {
                        $("#provinceField").append("<option value='" + item.id +
                            "'>" +
                            item.name + "</option>");
                    });
                }
            });
        });

        $("#provinceField").on('change', function () {
            $("#cityField option").remove();
            $("#cityField").append("<option value='' disabled selected>Select City</option>");
            let province_id = $(this).val();
            $.ajax({
                url: baseUrl + "/employees/jsonRegencies",
                type: 'GET',
                data: {
                    id: province_id,
                },
                dataType: 'json',
                success: function (rs) {
                    $.each(rs.data, function (i, item) {
                        $("#cityField").append("<option value='" + item.id +
                            "'>" +
                            item.name + "</option>");
                    });
                }
            });
        });
        // Create


        // Edit
        $("#provinceFieldEdit").on('change', function () {
            $("#cityFieldEdit option").remove();
            $("#cityFieldEdit").append("<option value='' disabled selected>Select City</option>");
            let province_id = $(this).val();
            $.ajax({
                url: baseUrl + "/employees/jsonRegencies",
                type: 'GET',
                data: {
                    id: province_id,
                },
                dataType: 'json',
                success: function (rs) {
                    $.each(rs.data, function (i, item) {
                        $("#cityFieldEdit").append("<option value='" + item.id +
                            "'>" +
                            item.name + "</option>");
                    });
                }
            });
        });
        // Edit

        $(".btn-ktp").on('click', function () {
            $("#showKTP").modal('show');
            $("#previewKTP").attr("src", baseUrl + "/storage/uploads/" + $(this).data('file'));
        });

        $(".btn-edit").on('click', function () {
            let id = $(this).data('id');
            console.log(id);
            $("#cityFieldEdit option").remove();
            $.ajax({
                url: baseUrl + "/employees/jsonProvinces",
                type: 'GET',
                dataType: 'json',
                success: function (rs) {
                    $.each(rs.data, function (i, item) {
                        $("#provinceFieldEdit").append("<option value='" + item.id +
                            "'>" +
                            item.name + "</option>");
                    });
                }
            });
            $.ajax({
                url: baseUrl + "/employees/jsonEmployee",
                data: {
                    id: id,
                },
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status == true) {
                        let dt = response.data;
                        console.log(dt);
                        $("#editModal").modal("show");
                        $("#form-update").attr("action", baseUrl + "/employees/" + dt
                            .id);
                        $("#provinceFieldEdit").val(dt.province_address);
                        $("#firstNameFieldEdit").val(dt.first_name);
                        $("#lastNameFieldEdit").val(dt.last_name);
                        $("#phoneNumberFieldEdit").val(dt.phone_number);
                        $("#ktpNumberFieldEdit").val(dt.ktp_number);
                        $("#emailFieldEdit").val(dt.email_address);
                        $("#dobFieldEdit").val(dt.date_of_birth);
                        $("#currentPositionFieldEdit").val(dt.current_position);
                        $("#bankAccountFieldEdit").val(dt.bank_account);
                        $("#bankAccountNumberFieldEdit").val(dt.bank_account_number);
                        $("#zipCodeFieldEdit").val(dt.zip_code);
                        $("#streetAddressFieldEdit").val(dt.street_address);
                        if (dt.city_address != null) {
                            $("#cityFieldEdit").append("<option value='" + dt.city_address +
                                "' selected>" + dt.city_name + "</option>");
                        } else {
                            $("#cityFieldEdit").append(
                                "<option value='' disabled selected>Select City</option>"
                            );
                        }
                    }
                }
            });
        })
    });

</script>
@endsection
