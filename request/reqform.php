<div class="container">
    <!--<FORM METHOD="post" action="<?php echo $script; ?>">-->
        <div class="row">
            <div class="col-sm-2">
                <!--<label for="fname">start typing title or artist:</label>-->
            </div>
            <div class="col-sm-8">
                <INPUT TYPE=text id="searchtext" NAME="searchtext" class="form-control" placeholder="Start typing Title OR Artist">
                    <div id="seachDIV" class="col-sm-12" style="overflow: auto; max-height: 200px;margin-left: -15px;width: 100%;position: absolute; z-index: 99; background: #fff;"></div>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-12">
                <form method="post" id="searchform" action="/request/request.php" style="display:none">
                    <input type="hidden" id="searchkey" name="rq" value="C:\Users\Big Kahuna\Desktop\Jammin 92\Throwbacks\2000s\2000\Candy Shop - 50 Cent.mp3">
                    <input type="hidden" name="name" maxlength="30" class="form-control" value="">
                    <input type="hidden" name="location" class="form-control" maxlength="30" value="">
                    <p></p><p align="center"><input type="hidden" name="searchtext" value="Candy Shop">
                    <input type="hidden" name="func" value="Send Your Request">
                    <input type="submit" name="submit" value="Submit Your Request" class="btn btn-primary">
                    </p></form>
            </div>
            
            <!--<div class="col-sm-3">
            <input type="hidden" name="func" value="Search">
            <input type="submit" name="submit" placeholder="Search.." value="Search" class="btn btn-primary">
            </div>-->
        </div>
<!--</FORM>-->
</div>

