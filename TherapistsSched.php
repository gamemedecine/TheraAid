<?php

include("databse.php");
session_start();
$var_Tid =  $_SESSION["sess_PTID"];
$var_Etime = "";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">-->
</head>

<body>
    <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="..." class="rounded me-2" alt="...">
                <strong class="me-auto">Bootstrap</strong>
                <small>11 mins ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
        </div>
    </div>

    <form id="InputSched">
        <input type="text" name="TxtID" value="<?php echo $var_Tid; ?>">
        <div class="Days">
            <input type="checkbox" name="CheckBoxDay[]" value="Mon" id="monday">
            <label for="monday">Monday</label>
            <input type="checkbox" name="CheckBoxDay[]" value="Tue" id="tuesday">
            <label for="tuesday">Tuesday</label>
            <input type="checkbox" name="CheckBoxDay[]" value="Wed" id="wednesday">
            <label for="wednesday">Wednesday</label>
            <input type="checkbox" name="CheckBoxDay[]" value="THU" id="thursday">
            <label for="thursday">Thursday</label>
            <input type="checkbox" name="CheckBoxDay[]" value="Fri" id="friday">
            <label for="friday">Friday</label>
            <input type="checkbox" name="CheckBoxDay[]" value="Sat" id="saturday">
            <label for="saturday">Saturday</label>
        </div>

        <input type="text" id="Note" place="Note" name="Note"><br>
        <select id="startTime" name="start_time">
            <option value="">--Start Time--</option>
            <?php

            for ($var_i = 7; $var_i <= 12; $var_i++) {
                echo "<option value=" . $var_i . ":00" . ">" . $var_i . ":00 AM</option>";
            }
            for ($var_j = 1; $var_j <= 5; $var_j++) {
                echo "<option value=" . ($var_j + 12) . ":00" . ">" . $var_j . ":00 PM</option>";
            }


            ?>
        </select>
        <br>
        <label for="endTime">End Time:</label>
        <select id="endTime" name="end_time">
            <option value="">--End Time--</option>
        </select>

        <button type="submit" id="Subbutton">Submit</button>
    </form>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>-->
    <script>
        document.getElementById("startTime").addEventListener("change", function() {
            const startTime = parseInt(this.value);

            const endTimeSelect = document.getElementById("endTime");

            endTimeSelect.innerHTML = '<option value="">--End Time--</option>';

            if (startTime >= 7 && startTime <= 16) {
                for (let i = startTime + 1; i <= 17; i++) {
                    let period = i < 12 ? "AM" : "PM";
                    let displayHour = i <= 12 ? i : i - 12;
                    endTimeSelect.innerHTML += `<option value="${i}:00">${displayHour}:00 ${period}</option>`;
                }
            }
        });
        const form = document.getElementById("InputSched");
        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            e.stopPropagation();
            const form = document.getElementById("InputSched");
            const StarTime = form["start_time"].value;
            const EndTime = form["end_time"].value;
            const Note = form["Note"].value
            const checkboxes = form["CheckBoxDay[]"];
            var Error = "";
            var isThereChecked = false;
            var therapists_id = form["TxtID"].value;
            var days = [];
            var Status = "Available";

            days = days.map((day) => {
                return day + ",";
            })

            // console.log(StarTime);

            //////////////////////////////////////


            for (var i = 0; i < checkboxes.length; i++) {
                const isChecked = checkboxes[i].checked;

                if (isChecked) {
                    isThereChecked = true;
                }
            }

            if (isThereChecked) {
                checkboxes.forEach((item) => {
                    if (item.checked) {
                        days.push(item.value)
                    }
                });
            } else {
                alert("Please select atleast 1 day");
                var Error = "Error";


            }
            if (StarTime === "" || EndTime === "") {
                alert("Please Enter value");
                var Error = "Error";

            }
            if (Note === "") {
                alert("Please Put Note");
                var Error = "Error";

            }
            if(Error == ""){
                try {
                const r = await fetch("./SchedAPI/SchedCheckerAPI.php", {
                    method: "POST",
                    body: JSON.stringify({
                        day: days,
                        start_time: StarTime,
                        therapists_id: therapists_id,
                    })
                });

                const rText = await r.text();

                if (rText === "1") {
                    alert("This schedule has already been taken.");
                }else if(rText === "2"){
                    alert("This time is in between the saved schedule");
                } else if (rText === "0") {
                    alert("This schedule is avaiable.");



                    try {
                        const response = await fetch("./SchedAPI/SchedPOST.php", {
                            method: "POST",
                            body: JSON.stringify({
                                therapists_id: therapists_id,
                                day: days,
                                start_time: StarTime,
                                end_time: EndTime,
                                note: Note,
                                status: Status
                            })

                        })
                        console.log(response.text());
                    } catch (err) {
                        console.log(err.message);
                    }
                    ////////////////////////////////////
                }
            } catch (err) {
                console.error(err.message);
            }
            }

            
        });
    </script>
</body>

</html>