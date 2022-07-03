<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.onload = function() {

        /**
         * Update Products
         * @type {HTMLCollectionOf<Element>}
         */
        var sub = document.getElementsByClassName("update");
        for (let i = 0; i < sub.length; i++) {
            sub[i].addEventListener("click", function (e) {
                e.preventDefault();
                if (
                    document.getElementsByClassName("name")[i].value != "" &&
                    document.getElementsByClassName("sku")[i].value != "" &&
                    document.getElementsByClassName("price")[i].value != "" &&
                    document.getElementsByClassName("description")[i].value != "" &&
                    document.getElementsByClassName("quantity")[i].value != ""
                ) {

                    const formData = new URLSearchParams();
                    formData.append('name', document.getElementsByClassName("name")[i].value);
                    formData.append('sku', document.getElementsByClassName("sku")[i].value);
                    formData.append('price', document.getElementsByClassName("price")[i].value.replace(/,/g, "."));
                    formData.append('description', document.getElementsByClassName("description")[i].value);
                    formData.append('quantity', document.getElementsByClassName("quantity")[i].value);
                    formData.append('id', document.getElementsByClassName("id")[i].value);

                    fetch('http://localhost:8000/products/update', {
                        method: 'POST',
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: formData.toString()
                    })
                        .then((res) => res.text())
                        .then((res) => {
                            var result = JSON.parse(res);
                            if (result.data === true) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                });

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Atualizando ...'
                                }).then(() => {
                                    window.location = "/";
                                })
                            }
                        });
                } else {
                    Swal.fire(
                        'Ops ...',
                        'Preencha todos os campos !',
                        'warning'
                    )
                }
            });
        }

        /**
         * Save categories
         */
        var saveCategory = document.getElementById("saveCategory");
        saveCategory.addEventListener("click", function (e) {
            e.preventDefault();

            if (document.getElementById("newcategory").value != "") {

                const formData = new URLSearchParams();
                formData.append('newcategory', document.getElementById("newcategory").value);

                fetch('http://localhost:8000/categories/categories', {
                    method: 'POST',
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: formData.toString()
                })
                    .then((res) => res.text())
                    .then((res) => {
                        var result = JSON.parse(res);
                        if (result.data === true) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'Salvando ...'
                            }).then(() => {
                                window.location = "/";
                            })
                        }
                    });
            } else {
                Swal.fire(
                    'Ops ...',
                    'Preencha todos os campos !',
                    'warning'
                )
            }
        });

    };
</script>


