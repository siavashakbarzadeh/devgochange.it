@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div id="main">
        <div class="table-wrapper">
            <div class="portlet light bordered portlet-no-padding">
                <div class="portlet-title">
                    <div class="caption">
                        <div class="wrapper-action">
                            <a href="{{ route('admin.emails.pec.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i>
                                Create
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive  table-has-actions   table-has-filter ">
                        <div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <table aria-describedby="botble-member-tables-member-table_info" role="grid"
                                class="table table-striped table-hover vertical-middle dataTable no-footer dtr-inline">
                                <thead>
                                <tr role="row">
                                    <th width="10px" class="text-start no-sort sorting_disabled" rowspan="1" colspan="1"
                                        style="width: 10px;" aria-label=""><input class="table-check-all"
                                                                                  data-set=".dataTable .checkboxes"
                                                                                  name="" type="checkbox"></th>
                                    <th title="ID" width="20px" class="column-key-id sorting_desc" tabindex="0"
                                        aria-controls="botble-member-tables-member-table" rowspan="1" colspan="1"
                                        style="width: 20px;" aria-sort="descending" aria-label="IDorderby asc">ID
                                    </th>
                                    <th title="Avatar" width="70px" class="column-key-avatar_id sorting" tabindex="0"
                                        aria-controls="botble-member-tables-member-table" rowspan="1" colspan="1"
                                        style="width: 70px;" aria-label="Avatarorderby asc">Avatar
                                    </th>
                                    <th title="Name" class="text-start column-key-first_name sorting" tabindex="0"
                                        aria-controls="botble-member-tables-member-table" rowspan="1" colspan="1"
                                        aria-label="Nameorderby asc" style="">Name
                                    </th>
                                    <th title="Email" class="text-start column-key-email sorting" tabindex="0"
                                        aria-controls="botble-member-tables-member-table" rowspan="1" colspan="1"
                                        aria-label="Emailorderby asc" style="">Email
                                    </th>
                                    <th title="Created At" width="100px" class="column-key-created_at sorting"
                                        tabindex="0" aria-controls="botble-member-tables-member-table" rowspan="1"
                                        colspan="1" style="width: 100px;" aria-label="Created Atorderby asc">Created At
                                    </th>
                                    <th title="Operations" width="134px" class="text-center sorting_disabled"
                                        rowspan="1" colspan="1" style="width: 134px;" aria-label="Operations">Operations
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr role="row" class="odd">
                                    <td class="text-start no-sort dtr-control">
                                        <div class="text-start">
                                            <div class="checkbox checkbox-primary table-checkbox">
                                                <input type="checkbox" class="checkboxes" name="id[]" value="10">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-key-id sorting_1">10</td>
                                    <td class="  column-key-avatar_id"><img
                                            src="http://127.0.0.1:8000/storage/651d1b29499641696406313-150x150.jpeg"
                                            alt="Wilburn Schuppe" width="50"></td>
                                    <td class=" text-start column-key-first_name" style=""><a
                                            href="http://127.0.0.1:8000/admin/members/edit/10">Wilburn Schuppe</a></td>
                                    <td class=" text-start column-key-email" style="">ystiedemann@yahoo.com</td>
                                    <td class="  column-key-created_at" style="">2023-07-19</td>
                                    <td class=" text-center">
                                        <div class="table-actions">

                                            <a href="http://127.0.0.1:8000/admin/members/edit/10"
                                               class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip"
                                               data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>

                                            <a href="#" class="btn btn-icon btn-sm btn-danger deleteDialog"
                                               data-bs-toggle="tooltip"
                                               data-section="http://127.0.0.1:8000/admin/members/10" role="button"
                                               data-bs-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="even">
                                    <td class="text-start no-sort dtr-control">
                                        <div class="text-start">
                                            <div class="checkbox checkbox-primary table-checkbox">
                                                <input type="checkbox" class="checkboxes" name="id[]" value="9">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-key-id sorting_1">9</td>
                                    <td class="  column-key-avatar_id"><img
                                            src="http://127.0.0.1:8000/storage/651d1b29830e71696406313-150x150.jpg"
                                            alt="Syble O'Hara" width="50"></td>
                                    <td class=" text-start column-key-first_name" style=""><a
                                            href="http://127.0.0.1:8000/admin/members/edit/9">Syble O'Hara</a></td>
                                    <td class=" text-start column-key-email" style="">zrosenbaum@crooks.com</td>
                                    <td class="  column-key-created_at" style="">2023-07-19</td>
                                    <td class=" text-center">
                                        <div class="table-actions">

                                            <a href="http://127.0.0.1:8000/admin/members/edit/9"
                                               class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip"
                                               data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>

                                            <a href="#" class="btn btn-icon btn-sm btn-danger deleteDialog"
                                               data-bs-toggle="tooltip"
                                               data-section="http://127.0.0.1:8000/admin/members/9" role="button"
                                               data-bs-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="text-start no-sort dtr-control">
                                        <div class="text-start">
                                            <div class="checkbox checkbox-primary table-checkbox">
                                                <input type="checkbox" class="checkboxes" name="id[]" value="8">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-key-id sorting_1">8</td>
                                    <td class="  column-key-avatar_id"><img
                                            src="http://127.0.0.1:8000/storage/651d1b29696fd1696406313-150x150.jpg"
                                            alt="Ken Abernathy" width="50"></td>
                                    <td class=" text-start column-key-first_name" style=""><a
                                            href="http://127.0.0.1:8000/admin/members/edit/8">Ken Abernathy</a></td>
                                    <td class=" text-start column-key-email" style="">eloise.franecki@gmail.com</td>
                                    <td class="  column-key-created_at" style="">2023-07-19</td>
                                    <td class=" text-center">
                                        <div class="table-actions">

                                            <a href="http://127.0.0.1:8000/admin/members/edit/8"
                                               class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip"
                                               data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>

                                            <a href="#" class="btn btn-icon btn-sm btn-danger deleteDialog"
                                               data-bs-toggle="tooltip"
                                               data-section="http://127.0.0.1:8000/admin/members/8" role="button"
                                               data-bs-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="even">
                                    <td class="text-start no-sort dtr-control">
                                        <div class="text-start">
                                            <div class="checkbox checkbox-primary table-checkbox">
                                                <input type="checkbox" class="checkboxes" name="id[]" value="7">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-key-id sorting_1">7</td>
                                    <td class="  column-key-avatar_id"><img
                                            src="http://127.0.0.1:8000/storage/651d1b2975ae21696406313-150x150.jpg"
                                            alt="Isac Wolf" width="50"></td>
                                    <td class=" text-start column-key-first_name" style=""><a
                                            href="http://127.0.0.1:8000/admin/members/edit/7">Isac Wolf</a></td>
                                    <td class=" text-start column-key-email" style="">ankunding.wyatt@gmail.com</td>
                                    <td class="  column-key-created_at" style="">2023-07-19</td>
                                    <td class=" text-center">
                                        <div class="table-actions">

                                            <a href="http://127.0.0.1:8000/admin/members/edit/7"
                                               class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip"
                                               data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>

                                            <a href="#" class="btn btn-icon btn-sm btn-danger deleteDialog"
                                               data-bs-toggle="tooltip"
                                               data-section="http://127.0.0.1:8000/admin/members/7" role="button"
                                               data-bs-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="text-start no-sort dtr-control">
                                        <div class="text-start">
                                            <div class="checkbox checkbox-primary table-checkbox">
                                                <input type="checkbox" class="checkboxes" name="id[]" value="6">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-key-id sorting_1">6</td>
                                    <td class="  column-key-avatar_id"><img
                                            src="http://127.0.0.1:8000/storage/651d1b2960dc51696406313-150x150.jpg"
                                            alt="Caroline Goldner" width="50"></td>
                                    <td class=" text-start column-key-first_name" style=""><a
                                            href="http://127.0.0.1:8000/admin/members/edit/6">Caroline Goldner</a></td>
                                    <td class=" text-start column-key-email" style="">walter.jovani@hotmail.com</td>
                                    <td class="  column-key-created_at" style="">2023-07-19</td>
                                    <td class=" text-center">
                                        <div class="table-actions">

                                            <a href="http://127.0.0.1:8000/admin/members/edit/6"
                                               class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip"
                                               data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>

                                            <a href="#" class="btn btn-icon btn-sm btn-danger deleteDialog"
                                               data-bs-toggle="tooltip"
                                               data-section="http://127.0.0.1:8000/admin/members/6" role="button"
                                               data-bs-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="even">
                                    <td class="text-start no-sort dtr-control">
                                        <div class="text-start">
                                            <div class="checkbox checkbox-primary table-checkbox">
                                                <input type="checkbox" class="checkboxes" name="id[]" value="5">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-key-id sorting_1">5</td>
                                    <td class="  column-key-avatar_id"><img
                                            src="http://127.0.0.1:8000/storage/651d1b2944b271696406313-150x150.jpg"
                                            alt="Irwin Beahan" width="50"></td>
                                    <td class=" text-start column-key-first_name" style=""><a
                                            href="http://127.0.0.1:8000/admin/members/edit/5">Irwin Beahan</a></td>
                                    <td class=" text-start column-key-email" style="">dcollier@corkery.com</td>
                                    <td class="  column-key-created_at" style="">2023-07-19</td>
                                    <td class=" text-center">
                                        <div class="table-actions">

                                            <a href="http://127.0.0.1:8000/admin/members/edit/5"
                                               class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip"
                                               data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>

                                            <a href="#" class="btn btn-icon btn-sm btn-danger deleteDialog"
                                               data-bs-toggle="tooltip"
                                               data-section="http://127.0.0.1:8000/admin/members/5" role="button"
                                               data-bs-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="text-start no-sort dtr-control">
                                        <div class="text-start">
                                            <div class="checkbox checkbox-primary table-checkbox">
                                                <input type="checkbox" class="checkboxes" name="id[]" value="4">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-key-id sorting_1">4</td>
                                    <td class="  column-key-avatar_id"><img
                                            src="http://127.0.0.1:8000/storage/651d1b299d7ea1696406313-150x150.jpg"
                                            alt="Jedidiah Schmidt" width="50"></td>
                                    <td class=" text-start column-key-first_name" style=""><a
                                            href="http://127.0.0.1:8000/admin/members/edit/4">Jedidiah Schmidt</a></td>
                                    <td class=" text-start column-key-email" style="">lehner.kelton@hickle.com</td>
                                    <td class="  column-key-created_at" style="">2023-07-19</td>
                                    <td class=" text-center">
                                        <div class="table-actions">

                                            <a href="http://127.0.0.1:8000/admin/members/edit/4"
                                               class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip"
                                               data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>

                                            <a href="#" class="btn btn-icon btn-sm btn-danger deleteDialog"
                                               data-bs-toggle="tooltip"
                                               data-section="http://127.0.0.1:8000/admin/members/4" role="button"
                                               data-bs-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="even">
                                    <td class="text-start no-sort dtr-control">
                                        <div class="text-start">
                                            <div class="checkbox checkbox-primary table-checkbox">
                                                <input type="checkbox" class="checkboxes" name="id[]" value="3">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-key-id sorting_1">3</td>
                                    <td class="  column-key-avatar_id"><img
                                            src="http://127.0.0.1:8000/storage/651d1b292db771696406313-150x150.gif"
                                            alt="Francesco Steuber" width="50"></td>
                                    <td class=" text-start column-key-first_name" style=""><a
                                            href="http://127.0.0.1:8000/admin/members/edit/3">Francesco Steuber</a></td>
                                    <td class=" text-start column-key-email" style="">ckiehn@hotmail.com</td>
                                    <td class="  column-key-created_at" style="">2023-07-19</td>
                                    <td class=" text-center">
                                        <div class="table-actions">

                                            <a href="http://127.0.0.1:8000/admin/members/edit/3"
                                               class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip"
                                               data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>

                                            <a href="#" class="btn btn-icon btn-sm btn-danger deleteDialog"
                                               data-bs-toggle="tooltip"
                                               data-section="http://127.0.0.1:8000/admin/members/3" role="button"
                                               data-bs-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="text-start no-sort dtr-control">
                                        <div class="text-start">
                                            <div class="checkbox checkbox-primary table-checkbox">
                                                <input type="checkbox" class="checkboxes" name="id[]" value="2">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-key-id sorting_1">2</td>
                                    <td class="  column-key-avatar_id"><img
                                            src="http://127.0.0.1:8000/storage/651d1b292b9371696406313-150x150.jpg"
                                            alt="Peggie Lynch" width="50"></td>
                                    <td class=" text-start column-key-first_name" style=""><a
                                            href="http://127.0.0.1:8000/admin/members/edit/2">Peggie Lynch</a></td>
                                    <td class=" text-start column-key-email" style="">newton.nader@gmail.com</td>
                                    <td class="  column-key-created_at" style="">2023-07-19</td>
                                    <td class=" text-center">
                                        <div class="table-actions">

                                            <a href="http://127.0.0.1:8000/admin/members/edit/2"
                                               class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip"
                                               data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>

                                            <a href="#" class="btn btn-icon btn-sm btn-danger deleteDialog"
                                               data-bs-toggle="tooltip"
                                               data-section="http://127.0.0.1:8000/admin/members/2" role="button"
                                               data-bs-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="even">
                                    <td class="text-start no-sort dtr-control">
                                        <div class="text-start">
                                            <div class="checkbox checkbox-primary table-checkbox">
                                                <input type="checkbox" class="checkboxes" name="id[]" value="1">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-key-id sorting_1">1</td>
                                    <td class="  column-key-avatar_id"><img
                                            src="http://127.0.0.1:8000/storage/651d1b29dc3c91696406313-150x150.jpg"
                                            alt="John Smith" width="50"></td>
                                    <td class=" text-start column-key-first_name" style=""><a
                                            href="http://127.0.0.1:8000/admin/members/edit/1">John Smith</a></td>
                                    <td class=" text-start column-key-email" style="">john.smith@botble.com</td>
                                    <td class="  column-key-created_at" style="">2023-07-19</td>
                                    <td class=" text-center">
                                        <div class="table-actions">

                                            <a href="http://127.0.0.1:8000/admin/members/edit/1"
                                               class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip"
                                               data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>

                                            <a href="#" class="btn btn-icon btn-sm btn-danger deleteDialog"
                                               data-bs-toggle="tooltip"
                                               data-section="http://127.0.0.1:8000/admin/members/1" role="button"
                                               data-bs-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
