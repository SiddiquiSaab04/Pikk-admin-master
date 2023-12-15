<div id="addons">
    <input type="hidden" name="product_addon" id="product_addon">
    <div id="app">
        <addon-component :addons="{{ $addons}}">

        </addon-component>
    </div>
</div>
@push('scripts')
    <script>
        var addons = @php echo $addons; @endphp;
        var checkboxes = [];
        var products = [];
        var selectedProducts = [];
        var selectedAddons = [];
        var selectedAddon = [];

        $("#addon_checks").hide();
        $("#addon_buttons").hide();

        $("#addon_group_id").bind('change', function(e) {
            selectedProducts = []
            selectedAddon = addons.find((addon) => addon.id == this.value)

            $("#checkboxes").html("")

            var div = $("<div></div>").addClass("form-inline row")
            var label = $("<label>Select All</label>").addClass("reverse selectAll")
            var checkbox = $("<input>").attr("class", "form-control mr-2")
                .attr("type", "checkbox")
                .attr('checked', 'true').bind('click', function(e) {
                    let checkbox = ($("input[type='checkbox']"))
                    var bool = checkbox[1].checked;
                    for (let i = 0; i < checkbox.length; i++) {
                        checkbox[i].checked = bool ? false : true
                    }
                })

            label.append(checkbox)
            div.append(label)
            $("#checkboxes").append(div)

            products = addons.find((addon) => addon.id == this.value).products
            products.map((product) => {
                div = $("<div></div>").addClass("form-inline row")
                label = $("<label>" + product.name + "</label>").addClass("reverse")
                checkbox = $("<input>").attr("class", "form-control mr-2")
                    .attr("name", product.addon_group_id)
                    .attr("type", "checkbox")
                    .attr("value", product.id)
                    .attr('checked', 'true')

                label.append(checkbox)
                div.append(label)

                $("#checkboxes").append(div)
                $("#addon_checks").show()
                $("#addon_buttons").show()
            })
        })

        $("#addon_button").bind('click', function(e) {
            let checkbox = ($("input[type='checkbox']"))
            if (checkbox.length > 0) {
                for (let i = 1; i < checkbox.length; i++) {
                    if (checkbox[i].checked) {
                        checkboxes.push(checkbox[i].value)
                    }
                }
                console.log(checkboxes)
                if (checkboxes.length > 0) {
                    for (let i = 0; i < checkboxes.length; i++) {
                        selectedProducts.push(products.find((product) => product.id == checkboxes[i]))
                    }
                }
            }

            selectedAddon.products = selectedProducts.filter(function(element) {
                return element != undefined;
            });

            selectedAddon.max_selection = document.getElementById('max_selection').value
            selectedAddons.push(selectedAddon)
            assignToInput()

            $("#addon_checks").hide()

            return displayAddons();
        })

        function displayAddons() {
            $("#addonBody").html("")
            for (var i = 0; i < selectedAddons.length; i++) {
                var tr = $("<tr></tr>");
                tr.append("<td>" + (i + 1) + "</td>")
                tr.append("<td>" + selectedAddons[i].name + "</td>")
                tr.append("<td>" + selectedAddons[i].max_selection + "</td>")

                var td = $("<td></td>")
                var ul = $("<ul></ul>")

                for (var j = 0; j < selectedAddons[i].products.length; j++) {
                    ul.append("<li>" + selectedAddons[i].products[j].name + "</li>")
                }

                td.append(ul)
                tr.append(td)
                tr.append("<td><button class='btn btn-danger' type='button' onclick='deleteRow(event)' aria-label='"+i+"'>Delete</button></td>")

                $("#addonBody").append(tr)
            }
        }

        function deleteRow(e) {
            let index = e.srcElement.ariaLabel
            selectedAddons.splice(index, 1);
            e.srcElement.parentElement.parentElement.remove()
            assignToInput();
            displayAddons();
        }

        function assignToInput()
        {
            document.getElementById('product_addon').value = JSON.stringify(selectedAddons)
        }
    </script>
@endpush
