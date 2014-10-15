
<div class="row">

    <div class="panel">
        <table>
            <tr>
                <td width="80" height="80" align="center">
                    <img src="<?php echo $store->logo; ?>" class="img-responsive img-circle" style="width:80px;height:80px;border:5px solid rgba(221, 221, 221, 0.62)">
                </td>
                <td style="padding-left:10px;">
                    <h2><?php echo $store->name; ?><small>－<?php echo $this->shop->name; ?></small></h2>
                </td>
            </tr>
        </table>
    </div>
    <div class="mbl">
        <div class="center_info col-lg-6">

            <div class="portlet box portlet-pink">
                <div class="portlet-header">
                    <div class="caption text-uppercase">验证订单</div>
                </div>
                <div class="portlet-body">
                    <form action='<?php echo $this->createUrl('orders/verify'); ?>#top-store' method="get" class="form-horizontal form-separated form-validate">
                        <div class="input-group">
                            <input type="number" name="code" id="verify_code" minlength="12" maxlength="12" placeholder="请输入12位验证码" class="form-control required number"/>
                            <span class="input-group-btn">
                                <button class="btn btn-pink"> 查 询 </button>
                            </span>
                        </div>
                        <em for="verify_code" class="invalid"></em>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>