<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-6">
                <form method="post" action="execize_action.php" class="form-container px-5">
                        <div class="form-group">
                            <h5>Where did you hear from us?</h5> <br>
                                <input type="checkbox" name="select[]"  value="selectall"  id="sel0"/> Select All <br>
                                <input type="checkbox" name="select[]" value="facebook"  id="sel1"/> Facebook <br>
                                <input type="checkbox" name="select[]" value="google ads"  id="sel2"/> Google Ads <br>
                                <input type="checkbox" name="select[]"  value="newspaper" id="sel3"/> Newspaper <br>                                    
                                <input type="checkbox" name="select[]"  value="Linda Ikeji" id="sel4"/> Linda Ikeji's Blog <br>
                                <input type="checkbox" name="select[]"  value="Moat academy" id="sel5"/> Moat Academy <br>
                                <input type="checkbox" name="select[]"  value="Punch" id="sel6"/> Punch Online <br>
                                <input type="checkbox" name="select[]"  value="other" id="sel7"/> Others
                     </div>


                <button type="submit" class="btn btn-dark col-12 mb-3" id="btn2" name="sub">Submit</button>
            </form>
            </div>
        </div>
    </div>
</body>
</html>