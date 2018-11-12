<?php $__env->startSection('title',  __('titles.product')); ?>
<?php $__env->startSection('content'); ?>

<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
                <a href="/dashboard" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
                <a href="javascript:void(0)" class="m-nav__link">
                        <span class="m-nav__link-text">Cadastros</span>
                </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
                <a href="javascript:void(0)" class="m-nav__link">
                        <span class="m-nav__link-text"><?php echo e(__('titles.add_product')); ?></span>
                </a>
        </li>
</ul>


<div class="row">
<div class="col-md-12">
<div class="m-portlet m-portlet--tabs">
<div class="m-portlet__head">
        <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                        <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">
                                        <?php if(isset($product)):?>
						<i class="la la-pencil"></i> Atualizar
					<?php else: ?>
						<i class="la la-plus"></i> Adicionar
					<?php endif; ?>
                                </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">
                                        Lista de Produtos
                                </a>
                        </li>
                </ul>
        </div>
</div>

<div class="m-portlet__body">
  <div class="tab-content">
     <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">

        <div class="col-md-12">

            <div class="m-portlet m-portlet--tab">

                <div class="m-portlet__head">

                    <div class="m-portlet__head-caption">


                        <div class="m-portlet__head-title">

                            <span class="m-portlet__head-icon m--hide">
						        <i class="la la-gear"></i>
						    </span>
                            <h3 class="m-portlet__head-text">
                                <?php echo e(__('titles.add_product')); ?>

                            </h3>
                        </div>

                    </div>
                </div>
                <?php echo e(Form::open(array('url' => url('api/products'), 'class'=>'m-form m-form--fit m-form--label-align-right ajax-form'))); ?>

                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-md-4">
                            <label for="type">Nome</label>
                            <input type="text" class="form-control m-input" name="type" id="type" data-validation="notempty($(this))" data-label="<?php echo e(__('labels.type')); ?>" data-error="<?php echo e(__('labels.field_not_empty')); ?>" placeholder="Nome do Produto" value="<?php if(isset($produto) && $produto->type): ?> <?php echo e($produto->type); ?> <?php endif; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="mod">Tipo</label>
                            <select class="form-control m-input m-input--square" name="mod" id="mod" data-validation="notempty($(this))">
                                <option disabled selected><?php echo e(__('labels.select')); ?></option>
                                <option value="documento" <?php if(isset($produto) && $produto->mod == 'documento'): ?> selected <?php endif; ?>;>Documento</option>
                                <option value="produto" <?php if(isset($produto) && $produto->mod == 'produto'): ?> selected <?php endif; ?>;>Produto</option>
                            </select>
                        </div>


                    </div>
                    <hr/>
                    <div class="form-group m-form__group row">
                        <div class="col-md-6">
                            <label for="description"><?php echo e(__('labels.description')); ?></label>
                            <textarea rows="1" class="form-control m-input" name="description" id="description"
                                      data-validation="notempty($(this))" data-label="<?php echo e(__('labels.bank_name')); ?>"
                                      data-error="<?php echo e(__('labels.field_not_empty')); ?>"
                                      placeholder="<?php echo e(__('labels.description')); ?>"> <?php if(isset($produto) && $produto->description): ?> <?php echo e($produto->description); ?> <?php endif; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <?php echo e(Form::submit(__('buttons.submit'), array('class' => 'btn btn-success'))); ?>

                        <button type="reset" class="btn btn-secondary"
                                onclick="window.history.back()"><?php echo e(__('buttons.cancel')); ?></button>
                    </div>
                </div>
                <?php echo e(csrf_field()); ?>

                <?php echo e(Form::close()); ?>


            </div>
        </div>
    </div>
    <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                                       <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
                                                <thead>
                                                        <tr>
                                                                <th scope="col">ID</th>
                                                                <th scope="col">PRODUTO</th>
                                                                <th scope="col">DESCRIÇÃO</th>
                                                                <th scope="col">TIPO</th>
                                                                <th scope="col"></th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $produtos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                                <td scope="row"><?php echo e($p->id); ?></td>
                                                                <td scope="row"><?php echo e($p->type); ?></td>
                                                                <td scope="row"><?php echo e($p->description); ?></td>
                                                                <td scope="row"><?php echo e($p->mod); ?></td>
                                                                <td class="text-center">
                                                                        <a href="/cadastros/produto/edit/<?php echo e($p->id); ?>" data-toggle="tooltip" title="<?php echo e(__('buttons.edit')); ?>" class="btn btn-outline-accent m-btn m-btn--icon m-btn--icon-only">
                                                                                <i class="fa fa-pencil"></i>
                                                                        </a>
                                                                        <a href="/cadastros/produto/remove/<?php echo e($p->id); ?>" data-toggle="tooltip" title="<?php echo e(__('buttons.delete')); ?>" onclick="if(confirm('Deseja remover esse registro ?')){return true;}else{return false;}" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only">
                                                                                <i class="fa fa-remove"></i>
                                                                        </a>
                                                                </td>
                                                        </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                        </table>
    </div>
  </div>
</div>

</div>
</div>
</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>