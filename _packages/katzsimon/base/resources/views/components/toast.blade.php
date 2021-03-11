@php $message = json_decode(session()->get('message'), true); if(!is_array($message)) dd($message); @endphp
<div class="toaster {{ $message['type']??'' }}" id="toast">
    {!! $message['message']??'' !!}
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" id="closeToast" class="absolute top-1 right-1 cursor-pointer">
        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
    </svg>
</div>
<script type="text/javascript">
    var toast = document.querySelector("#toast");
    setTimeout(function(){
        toast.remove();
    }, 10000);
    document.querySelector("#closeToast").addEventListener('click', function (e) {
    	toast.remove();
    });
</script>
