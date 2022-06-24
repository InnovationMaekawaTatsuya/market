$(function() {

    let like = $('.js-like-toggle');
    let likeItemId;

    like.on('click', function () {
        let $this = $(this);
        likeItemId = $this.data('itemid');  //ここ$thisって何が入っているの？
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/ajaxlike', //ルーティング
            type: 'post', //タイプ指定
            data: {
                'item_id': likeItemId, //コントローラに渡すパラメータ（中身の情報）
            }

        })// リクエストが成功した時
        .done(function(data){
            // toggleClass->指定したクラスが要素にセットされていれば削除、なければ追加
            $this.toggleClass('loved');
            $this.next('.likesCount').html(data.itemLikesCount);
        })
        // リクエストが失敗した時
        .fail(function (data, xhr, err){
            alert('エラーです。');
            console.log(xhr);
            console.log(err);
            console.log(data);
        })
        ;
    });
});