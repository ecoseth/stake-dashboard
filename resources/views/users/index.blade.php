@extends("layouts.app")
@section('content')
<!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="mb-2">
        <h1 class="m-0">Users</h1>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6 mb-3">
              <input
                class="form-control"
                type="search"
                placeholder="Search with user id or wallet address"
                aria-label="Search"
              />
            </div>
            <div class="col-md-6">
              <div class="float-right">
                <small>Connected Wallet:</small>
                <button type="button" class="btn btn-primary">
                  Connect
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>User Id</th>
                <th>Wallet Address</th>
                <th>Balance</th>
                <th>Real Balance (USDT)</th>
                <th>Status</th>
                <th style="width: 40px">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>
                  <span>111481</span> <br />
                  <span class="badge bg-success">joined</span>
                </td>
                <td>
                  <span>Wallet: 123456789ldwofgwlllwfo1234dwfwwfw</span>
                  <br />
                  <span
                    >Spender: dwfwf2349ldwofgwlllwfo342er2fr2er31</span
                  >
                </td>
                <td>
                  <span>0</span> <br />
                  <span class="badge bg-primary">
                    16-10-2023 04:18 AM
                  </span>
                </td>
                <td>
                  <span>0.47</span> <br />
                  <span class="badge bg-primary">
                    16-10-2023 04:18 AM
                  </span>
                </td>
                <td>
                  <span class="badge bg-success">Approved</span>
                </td>
                <td>
                  <button class="btn btn-secondary">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td><span>111481</span> <br /></td>
                <td>
                  <span>Wallet: 123456789ldwofgwlllwfo1234dwfwwfw</span>
                  <br />
                  <span
                    >Spender: dwfwf2349ldwofgwlllwfo342er2fr2er31</span
                  >
                </td>
                <td>
                  <span>0</span> <br />
                  <span class="badge bg-primary">
                    16-10-2023 04:18 AM
                  </span>
                </td>
                <td>
                  <span>0.47</span> <br />
                  <span class="badge bg-primary">
                    16-10-2023 04:18 AM
                  </span>
                </td>
                <td>
                  <span class="badge bg-success">Approved</span>
                </td>
                <td>
                  <button class="btn btn-secondary">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td>
                  <span>111481</span> <br />
                  <span class="badge bg-success">joined</span>
                </td>
                <td>
                  <span>Wallet: 123456789ldwofgwlllwfo1234dwfwwfw</span>
                  <br />
                  <span
                    >Spender: dwfwf2349ldwofgwlllwfo342er2fr2er31</span
                  >
                </td>
                <td>
                  <span>0</span> <br />
                  <span class="badge bg-primary">
                    16-10-2023 04:18 AM
                  </span>
                </td>
                <td>
                  <span>0.47</span> <br />
                  <span class="badge bg-primary">
                    16-10-2023 04:18 AM
                  </span>
                </td>
                <td>
                  <span class="badge bg-success">Approved</span>
                </td>
                <td>
                  <button class="btn btn-secondary">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <td>4</td>
                <td>
                  <span>111481</span> <br />
                  <span class="badge bg-success">joined</span>
                </td>
                <td>
                  <span>Wallet: 123456789ldwofgwlllwfo1234dwfwwfw</span>
                  <br />
                  <span
                    >Spender: dwfwf2349ldwofgwlllwfo342er2fr2er31</span
                  >
                </td>
                <td>
                  <span>0</span> <br />
                  <span class="badge bg-primary">
                    16-10-2023 04:18 AM
                  </span>
                </td>
                <td>
                  <span>0.47</span> <br />
                  <span class="badge bg-primary">
                    16-10-2023 04:18 AM
                  </span>
                </td>
                <td>
                  <span class="badge bg-success">Approved</span>
                </td>
                <td>
                  <button class="btn btn-secondary">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <td>5</td>
                <td><span>111481</span> <br /></td>
                <td>
                  <span>Wallet: 123456789ldwofgwlllwfo1234dwfwwfw</span>
                  <br />
                  <span
                    >Spender: dwfwf2349ldwofgwlllwfo342er2fr2er31</span
                  >
                </td>
                <td>
                  <span>0</span> <br />
                  <span class="badge bg-primary">
                    16-10-2023 04:18 AM
                  </span>
                </td>
                <td>
                  <span>0.47</span> <br />
                  <span class="badge bg-primary">
                    16-10-2023 04:18 AM
                  </span>
                </td>
                <td>
                  <span class="badge bg-success">Approved</span>
                </td>
                <td>
                  <button class="btn btn-secondary">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content -->
@endsection