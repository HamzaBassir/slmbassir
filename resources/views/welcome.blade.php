<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css"
        integrity="sha512-wnea99uKIC3TJF7v4eKk4Y+lMz2Mklv18+r4na2Gn1abDRPPOeef95xTzdwGD9e6zXJBteMIhZ1+68QC5byJZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>

    <div class="h-full w-full slm-container flex justify-center items-center">
        <div class="w-5/6 md:w-3/6 lg:w-3/6 h-full flex justify-center items-center dpele flex-col">
            <form id="addfile" action="" enctype="multipart/form-data">
                <h2 class="text-lg text-center	font-medium	text-gray-500">Ajouter Un Fichier Zip Contient Les Fichies
                    Excel</h2>
                <div class="mt-3">
                    <div class="flex justify-center">
                        <div class="mb-3 w-96">

                            <input id="file" class="form-control
                          block
                          w-full
                          px-3
                          py-1.5
                          text-base
                          font-normal
                          text-gray-700
                          bg-gray-100 bg-clip-padding
                          border border-solid border-gray-300
                          rounded
                          transition
                          ease-in-out
                          m-0
                          focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file"
                                id="formFile">
                        </div>
                    </div>
                </div>
                <div class="progressbar w-full bg-gray-200 rounded-full dark:bg-gray-700 my-3 hideprogressbar">
                    <div class="progressbarbar bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: 0%"> 0%</div>
                  </div>
                <div class="flex justify-center">
                    <button id="submitbutton" type="submit"
                        class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"><A>Importer</A></button>
                </div>
               
            </form>

        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $('#addfile').submit(function (e) {
            $('.progressbar').removeClass('hideprogressbar')
            $(':input[type="submit"]').prop('disabled', true); e.preventDefault();
            var file = $('#file')[0].files[0]
            const formData = new FormData();
            formData.set("shapefile", file);

            const config = {
                onUploadProgress: (progressEvent) => {
                    const { loaded, total } = progressEvent;
                    var percentage = Math.round((loaded*100)/total)
                    $('.progressbarbar').css("width", `${percentage}%`);;
                    $('.progressbarbar').html(`${percentage}%`);;
                },}


            axios.post('api/addfile', formData,config).then((result) => {
                $('.progressbar').addClass('hideprogressbar');
                if(result.data > 0 && result.data != 'duplicated'){
                    toastr.success('Fichiers importés avec succès', {timeOut: 1000})
                    toastr.info(`Mais il y avait ${result.data} fichiers en double`, {timeOut: 3000,"positionClass": "toast-bottom-left",})
                }else if(result.data == 0){
                    toastr.success('Fichiers importés avec succès', {timeOut: 1000})
                }
                if(result.data == 'duplicated'){
                    toastr.warning('Aucun fichier importé, tous dupliqués', {timeOut: 1000})

                }
                $(':input[type="submit"]').prop('disabled', true);
            }).catch((err) => {
                $('.progressbar').addClass('hideprogressbar');
                toastr.error('Les fichiers n\'ont pas été importés', {timeOut: 2000})
                $(':input[type="submit"]').prop('disabled', true);
            });

        });
    </script>
</body>

</html>