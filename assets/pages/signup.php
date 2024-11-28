<div class="login">
    <div class="col-lg-4 col-md-8 col-sm-12 bg-white border rounded p-4 shadow-sm">
        <form method="post" action="assets/php/action.php?signup">
            <div class="text-center mb-4">
                <img src="#" alt="" height="45">
            </div>
            <h1 class="h5 mb-3 fw-normal">Criar nova conta</h1>
            
            <div class="d-flex mb-3">
                <input type="text" name="first_name" class="form-control me-2" placeholder="Nome">
                <input type="text" name="last_name" class="form-control" placeholder="Sobrenome">
            </div>

            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email">
            </div>

            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Usuario">
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Senha">
            </div>


            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" type="submit">Cadastrar</button>
                <a href="?login" class="text-decoration-none">ter a conta</a>
            </div>
        </form>
    </div>
</div>