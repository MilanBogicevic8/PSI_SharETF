            <div class="row">
                <div class="col-3 bg-light p-2 px-4">
                    <h4 class = "mb-2">Pretraga:</h4>
                    <input type="text" class="form-control mb-2" id="search-term" placeholder = "Ime korisnika/Naziv grupe">
                    <select class="form-select mb-2" id = "search-type">
                        <option selected value="profile">Profili</option>
                        <option value="group">Grupe</option>
                    </select>
                    <button type = "button" class = "btn btn-secondary" id = "search-button">Kreni</button>
                </div>
                <div class="col-9" id = "search-results">

                </div>
            </div>
        </div>
        <script src = "/sharetf/public/scripts/elements.js"></script>
        <script>
            $(document).ready(function() {
                $("#search-button").click(function() {
                  $("#search-results").html("");
                  let term = $("#search-term").val();
                  term = (term == "" ? "all" : term);
                  let type = $("#search-type").val();
                  let maker = type == "profile" ? makeProfilePreview : makeGroupPreview;
                  
                  let xhr = new XMLHttpRequest();
                  xhr.open('GET', '/sharetf/public/index.php/User/getSearchResults/' + term + '/' + type, true);

                  xhr.onload = function() {
                    if (this.status == 200) {
                      let data = JSON.parse(this.responseText);
                      for (let i = 0; i < data.length; i++) $("#search-results").append(maker(data[i]));
                    } else {
                      console.error('Error fetching data');
                    }
                  };
                  xhr.send();
                })
            })
        </script>
        </body>
</html>