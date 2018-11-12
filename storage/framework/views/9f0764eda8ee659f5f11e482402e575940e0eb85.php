<?php $__env->startSection('title',  __('titles.alerts')); ?>
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
                        <span class="m-nav__link-text"><?php echo e(__('titles.list_alerts')); ?></span>
                </a>
        </li>
</ul>
<div class="row">
<div class="col-md-12" style="background-color:#fff">

<div class="m-portlet__body">
<div class="tab-content">

	<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
		<thead>
			<tr>
				<th scope="col">ID</th>
				<th scope="col">Data</th>
				<th scope="col">Hora</th>
				<th scope="col">Tipo</th>
				<th scope="col">Descrição</th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
		<?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td scope="row"><?php echo e($a->id); ?></td>
			<td scope="row"><?php echo e(\Carbon\Carbon::parse($a->date_ref)->format('d/m/Y')); ?></td>
			<td scope="row"><?php echo e($a->time_ref); ?></td>
			<td scope="row"><?php echo e($a->tipo); ?></td>
			<td scope="row"><?php echo e($a->desc); ?></td>
			<td class="text-center">
				<a href="/ocorrencias/edit/<?php echo e($a->id); ?>" data-toggle="tooltip" title="<?php echo e(__('buttons.edit')); ?>" class="btn btn-outline-accent m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil"></i></a>
				<a href="/ocorrencias/remove/<?php echo e($a->id); ?>" data-toggle="tooltip" title="<?php echo e(__('buttons.delete')); ?>" onclick="if(confirm('Deseja remover esse registro ?')){return true;}else{return false;}" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-remove"></i></a>
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