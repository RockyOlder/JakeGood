
<style>
    h1, h2, h3, h4, h5, h6 {
        font-family: "Open Sans", sans-serif;
        font-weight: 300;
    }
    #error-page-content {
        width: 480px;
        margin: 10% auto 0 auto;
        text-align: center;
    }
    #error-page-content h1 {
        font-family: 'oswald';
        font-size: 40px;
        font-weight: bold;
    }
    #error-page-content p a {
        color: #e82a62;
    }
</style>
<div id="error-page-content">
    <h1><?php echo $title; ?></h1>
    <h4><?php echo $message; ?></h4>
    <br />
    <p>                      
        <?php echo CHtml::link('返回', $returnUrl); ?>
    </p>
</div>
