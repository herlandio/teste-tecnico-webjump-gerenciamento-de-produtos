<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.onload = function() {

        var sub = document.getElementById("saveProducts");

        /**
         * Return value of fields
         * @param id
         * @returns {*}
         */
        var vFields = function(id) {
            return document.getElementById(id).value
        }

        /**
         * Save Products
         */
        sub.addEventListener("click", function (e) {
            e.preventDefault();
            if (
                vFields("name") != "" &&
                vFields("sku") != "" &&
                vFields("price") != "" &&
                vFields("description") != "" &&
                vFields("quantity") != ""
            ) {

                const formData = new URLSearchParams();
                formData.append('name', vFields("name"));
                formData.append('sku', vFields("sku"));
                formData.append('price', vFields("price"));
                formData.append('description', vFields("description"));
                formData.append('quantity', vFields("quantity"));

                var optionsCategories = document.getElementById("category").options;
                var categories = [];

                for (let i = 0; i < optionsCategories.length; i++) {
                    if (optionsCategories[i].selected === true) {
                        if (optionsCategories[i].value === "") {
                            Swal.fire(
                                'Ops ...',
                                'Selecione uma categoria ou cadastre uma, antes de criar um produto !',
                                'warning'
                            )
                            return false;
                        } else {
                            categories.push({category: optionsCategories[i].value});
                        }
                    }
                }

                formData.append('category', JSON.stringify(categories));

                fetch('http://localhost/products/save', {
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
