<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 07/01/2019
 * Time: 22:27
 */
?>

<!-- begin .flash-message -->
@foreach (['danger', 'warning', 'success', 'info'] as $k => $msgtype)
    @if(Session::has('alert-' . $msgtype))
        <div class="modal fade show" id="flashmessage-{{ $k }}" tabindex="-1"
             role="dialog" aria-labelledby="flashmessage-{{ $k }}_dataModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-{{ $msgtype }}">
                        <h5 class="modal-title">
                            {!! __('labels.alert-'. $msgtype) !!}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{ Session::get('alert-' . $msgtype) }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-{{ $msgtype }}"
                                data-dismiss="modal">{{__('buttons.close')}}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
<!-- end .flash-message -->

        <script type="text/javascript">
            $(function () {
                $('[id^="flashmessage"]').modal('show');
            });
        </script>
