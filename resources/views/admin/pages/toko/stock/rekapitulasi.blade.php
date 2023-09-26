<x-admin-layout titlePage="{{ $titlePage }}">


    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="w-100 d-flex align-items-center">
                        <div class="d-flex align-items-center">
                            <h5 class="m-0 mx-2 fw-bold">Lokasi : </h5>
                            <div class="mx-2">
                                <select class="form-select form-select w-100" aria-label="Default select example"
                                    name="store" id="store" value="1">
                                    @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="generateReport" class="btn btn-primary mx-5">Generate Report</div>
                    </div>
                </div>
            </div>
            <div class="card" id="cardResult" style="display: none">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex">
                            <a href="" class="btn btn-success" id="btnDownloadExcel">Download Excel</a>
                        </div>
                        <div class="w-25">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari produk" id="searchForm">
                                <button class="btn btn-primary" type="button" id="btnSearch">Cari</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead class="table-primary fw-bold">
                            <tr>
                                <th rowspan="2" class="text-center" style="vertical-align: middle !important">No</th>
                                <th rowspan="2" data-sort="products.name" class="text-center btn-sort cursor-pointer" style="vertical-align: middle !important">produk <span class="icon-sort"></span></th>
                                <th rowspan="2" data-sort="products.sku" class="text-center btn-sort cursor-pointer" style="vertical-align: middle !important">sku <span class="icon-sort"></span></th>
                                <th rowspan="2" data-sort="stocks.store_id" class="text-center btn-sort cursor-pointer" style="vertical-align: middle !important">lokasi <span class="icon-sort"></span></th>
                                <th rowspan="2" data-sort="prices.cost" class="text-center btn-sort cursor-pointer" style="vertical-align: middle !important">biaya <span class="icon-sort"></span></th>
                                <th rowspan="2" data-sort="prices.revenue" class="text-center btn-sort cursor-pointer" style="vertical-align: middle !important">harga <span class="icon-sort"></span></th>
                                <th rowspan="2" data-sort="stocks.qty" class="text-center btn-sort cursor-pointer" style="vertical-align: middle !important">jumlah <span class="icon-sort"></span></th>
                                <th colspan="2" class="text-center">nilai (Rp)</th>
                            </tr>
                            <tr>
                                <th class="text-center">biaya</th>
                                <th class="text-center">harga</th>
                            </tr>
                        </thead>
                        <tbody id="bodyTable">
                            <tr id="loadingRow">
                                <td colspan="9" class="text-center">Sedang mengambil data ...</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-4 d-flex justify-content-between align-items-center" id="pagination">
                      <div id="pageLink"></div>
                      <div id="infoData">
                        
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <x-slot name="scriptVendor">
        <script src="{{ asset('/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
        <script src="{{ asset('../assets/plugins/select2/select2.full.min.js') }}"></script>
    </x-slot>

    @slot('script')
    <script>
        $(document).ready(function () {
            let search = false;
            let sortBy = false;
            let sortMethod = false;
            let page = 1;
            let lastPage = 1;
            let loading = false;
            
            $("#generateReport").click(function () {
                search = false;
                sortBy = false;
                sortMethod = false;

                $('.icon-sort').each(function(i, obj) {
                    $(obj).html("")
                });

                $("#cardResult").show();
                generateData();
            });

            $("#btnSearch").click(function(){
              if(loading == false){
                let value = $("#searchForm").val();
                sortBy = false;
                sortMethod = false;
                page = 1;

                $('.icon-sort').each(function(i, obj) {
                    $(obj).html("")
                });
  
                search = value;
                // if(value != ''){
                // }

                generateData()
              }
            })

            $("#cardResult").on("click", ".btn-page", function(){
              if(loading == false){
                let value = parseInt($(this).text());
                if(isNaN(value)){
                  if($(this).text().search('Previous') > -1){
                    if(page == 1){
                      return false;
                    }else{
                      page -= 1;
                      generateData();
                    }
                  }else if($(this).text().search('Next') > -1){
                    if((page + 1) > lastPage){
                      return false;
                    }else{
                      page += 1;
                      generateData();
                    }
                  }else{
                    return false;
                  }
                }else{
                  page = value
                  generateData();
                }
                
              }
            })

            $(".btn-sort").click(function(){
              if(loading == false){
                page = 1;
                $('.icon-sort').each(function(i, obj) {
                    $(this).html("")
                });
                let sortParam = $(this).data('sort');
                if(sortMethod == false){
                  sortBy = sortParam;
                  sortMethod = 'asc';
                }else{
                  if(sortBy == sortParam){
                    if(sortMethod == 'asc'){
                      sortMethod = 'desc';
                    }else{
                      sortMethod = 'asc'
                    }
                  }else{
                    sortBy = sortParam;
                    sortMethod = 'asc';
                  }
                }

                if(sortMethod == 'asc'){
                  $(".btn-sort[data-sort='" + sortBy + "']").children('.icon-sort').html("<i class='fe fe-chevron-up'></i>")
                }else{
                  $(".btn-sort[data-sort='" + sortBy + "']").children('.icon-sort').html("<i class='fe fe-chevron-down'></i>")
                }
  
                generateData()
              }
            })

            function generateData(){
              if(loading == false){
                loading = true;
                $('#bodyTable').html('')
                $("#pageLink").html("")
                $("#infoData").html('')
  
                $('#bodyTable').html(`
                  <tr id="loadingRow">
                      <td colspan="9" class="text-center">Sedang mengambil data ...</td>
                  </tr>
                `)
  
                let store = $("#store").val();
                
                let param = '?store=' + store;
  
                if(search != false){
                  param += '&search=' + search;
                }
  
                if(sortBy != false){
                  param += '&order_by=' + sortBy;
                }
  
                if(sortMethod != false){
                  param += '&order_method=' + sortMethod;
                }
  
                
                param += '&page=' + page;
  
                let url = "{{ url('/api/rekapitulasi-stock') }}" + param;
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "json",
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: 'application/json',
                    cache: false,
                    success: function (response) {
                        lastPage = Math.ceil(response.total/response.perPage)
                        renderTable(response)
                        loading = false;
                        
                      },
                      error: function (xhr, status, error) {
                        swal({
                          title: "Gagal",
                          text: error,
                          type: "error"
                        });
                        loading = false;
                        $("#cardResult").hide();
                    }
                });

              }
              
            }

            function renderTable(datas){
              html = '';
              $('#bodyTable').html('')
              datas.data.forEach((data, i) => {
                
                html+= `
                  <tr>
                    <td class="text-center">`+ (((datas.current*datas.perPage) - datas.perPage) + i + 1) +`</td>
                    <td>` + data.name + `</td>
                    <td>` + data.sku + `</td>
                    <td>` + data.store_name + `</td>
                    <td>` + formatRupiah(String(data.cost), 'Rp ') + `</td>
                    <td>` + formatRupiah(String(data.revenue), 'Rp ') + `</td>
                    <td>` + data.qty + `</td>
                    <td>` + formatRupiah(String((data.qty * data.cost)), 'Rp ') + `</td>
                    <td>` + formatRupiah(String((data.qty * data.revenue)), 'Rp ') + `</td>
                  </tr>
                `;
              });
              $('#bodyTable').html(html)

              // page panel
              $("#pageLink").html("")
              let pageHtml = `<div class="btn-group btn-group-sm" role="group">`;
              datas.links.forEach((link, i) => {
                pageHtml += `<button type="button" class="btn-page btn ` + (link.active ? `btn-primary active-page` : `btn-outline-primary`) + `" data-page="` + link.url + `">` + link.label + `</button>`
              })
              pageHtml += `</div>`;
              $("#pageLink").html(pageHtml)

              // info panel
              $("#infoData").html('')
              let infoHtml = `<span>Show ` + datas.first + ` - ` + datas.last + ` from ` + datas.total + `</span>`;
              $("#infoData").html(infoHtml)
            }

            $("#btnDownloadExcel").click(function(e){
              e.preventDefault();
              // $(this).attr("href", "{{ route('admin.rekapitulasi-print') }}?store=" + $("#store").val());
              window.open( "{{ route('admin.rekapitulasi-print') }}?store=" + $("#store").val(), '_blank');
            })
        })

    </script>
    @endslot

    @slot('style')
    <style>
      .cursor-pointer{
        cursor: pointer;
      }
    </style>
    @endslot
</x-admin-layout>
