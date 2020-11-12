<link rel="stylesheet" type="text/css" href="{{ asset('assets/croppie/croppie.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/croppie/demo/demo.css') }}">
<style>
    /* .upload-msg,
    .cr-boundary {
        height: 400px !important;
        width: 400px !important;
        position: absolute;
    }
    
    #upload {
        display: none
    } */
    .upload-demo-wrap {
        width: 100%;
        height: {{isset($width) ? $width.'px' : '200px'}} ;
    }
</style>

<div class="demo-wrap upload-demo">
    <div class="container">
        <div class="grid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <strong>{{$head}}</strong>

                        <div class="actions">
                            <a class="btn file-btn">
                                <span class="btn btn-primary">انتخاب عکس</span>
                                <input type="file" id="upload" value="Choose a file" accept="image/*" />
                                <input type="hidden" name="image_file" class="image_file">
                                {{-- <img src="" alt="" id="preview_image_crop" class="m-auto"> --}}
                            </a>
                            <button class="upload-result btn btn-primary btn-md my-2 " type="submit"><i></i>ارسال جهت بررسی</button>
                        </div>
                    </div>
                    <div class="row">
                        <label for="upload" class="upload-msg w-100">
                            انتخاب عکس
                        </label>
                        <div class="upload-demo-wrap">
                            <div id="upload-demo"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="{{ asset('assets/croppie/croppie.js') }}"></script>
<!-- <script src="{{ asset('assets/croppie/demo/demo.js') }}"></script> -->

<script>
    $(document).ready(function() {
        var $uploadCrop;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.upload-demo').addClass('ready');
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(resp) {
                        console.log('jQuery bind complete');

                        $('.image_file').val(resp);
                    });

                }

                reader.readAsDataURL(input.files[0]);
            } else {
                // swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: "{{isset($width) ? $width : '200'}}",// 200,
                height:"{{isset($height) ? $height : '200'}}",// 200,
                type: "{{isset($type) ? $type : ''}}"// 'circle'
            },
            enableExif: true
        });

        $('#upload').on('change', function() {
            readFile(this);
        });

        $('.upload-result').on('click', function(ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function(resp) {
                // popupResult({
                // 	src: resp
                // });
                $('.image_file').val(resp);
                $('#preview_image_crop').attr('src', resp)
                    // console.log(resp)
            });
        });
    })
</script>