<script>
    $(document).ready(function(){
        $(document).on('click',"#walletHistory",function(){
            document.getElementById('loading').style.display = 'block';
            var customre_id=$(this).attr("customre-id");
            $("#walletDetails").html('');

            $.ajax({
                url:"/dashboard/walletHistory/" + customre_id,
                metod:"GET",
                success:function(response)
                {

                    let walletDetailsHtml = '';
                    $.each(response, function(index, transaction) {
                    const createdAt = new Date(transaction.created_at);
                    const formattedDate = createdAt.toISOString().slice(0, 19).replace("T", " ");
                    walletDetailsHtml += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${transaction.wallet.customer.name}</td>
                            <td>${transaction.wallet.customer.email}</td>
                            <td>${transaction.wallet.customer.phone}</td>
                            <td>${transaction.action}</td>
                            <td>${transaction.amount}</td>
                            <td>${formattedDate}</td>
                        </tr>
                    `;
            })


            $("#walletDetails").html(walletDetailsHtml);
            $('#myModal').modal('show');
            document.getElementById('loading').style.display = 'none';

                },
                error:function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown);
                }
            })

        })
    });
</script>


