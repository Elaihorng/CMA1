@extends('backend.layout.master')
@section('title','Stock History')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Stock In/Out History</h3>
                   
                  </div>

                  <div class="card-body p-0">
                    <table class="table table-bordered table-striped mb-0">
                      <thead>
                        <tr>
                          <th style="width: 30px;">#</th>
                          <th>Product Name</th>
                          <th>Type</th>
                          <th>Quantity</th>
                          <th>Note</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($stocks as $key => $stock)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $stock->product->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $stock->type == 'in' ? 'success' : 'danger' }}">
                                    {{ ucfirst($stock->type) }}
                                </span>
                            </td>
                            <td>{{ $stock->quantity }}</td>
                            <td>{{ $stock->note ?? '-' }}</td>
                            <td>{{ $stock->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No stock history found.</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
        </div>
    </section>
</div>

@endsection
