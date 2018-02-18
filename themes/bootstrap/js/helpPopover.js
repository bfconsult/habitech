var test = {"id":"1","scope":"actors","name":"Actors","text":"Actors are people"};
function HelpPopover(allHelps){
    $scope = this;
    $scope.currentIndex = -1;
    $scope.currentElement = null;
    $scope.visibilityInterval = null;
    $scope.allHelps = allHelps?allHelps:[];

    $scope.init = function(){
        var allHelpsClasses = $.map( allHelps, function( n, i ) {
            return '.' + n.scope;
        });
        $(allHelpsClasses.join(',')).popover({
            html: true,
            title: 'loading',
            content: 'loading',
            template: '<div class="popover"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div><div class="popover-footer"><a href="#" >Don\'t show this again</a></div></div>'
        });
        $(allHelpsClasses.join(',')).on('show.bs.popover', function() {
            $(this).data('popover').options.title = $scope.allHelps[$scope.currentIndex].name + ' <button  type="button" class="close">&times;</button>';
            $(this).data('popover').options.content = $scope.allHelps[$scope.currentIndex].text;
        });
        $(allHelpsClasses.join(',')).on('hide.bs.popover', function() {
            $scope.currentElement.popover('disable');
        });
        $(allHelpsClasses.join(',')).on('hidden.bs.popover', function() {
            $scope.showNext();
        });
        $(document).on("click", ".popover-footer a", function() {
            $.ajax({
                type: "GET",
                url: userHelpBlockUrl + $scope.allHelps[$scope.currentIndex].scope,
                dataType: 'JSON'
            })
                .done(function(data) {
                    console.log("Data Saved: ", data);
                });
            $scope.hideThis();
        });
        $(document).on("click", ".popover-title button.close", function() {
            $scope.hideThis();
        });
    };

    $scope.hideThis = function(){
        $scope.currentElement.popover('hide');
    }

    $scope.showNext = function(){

        $scope.currentIndex++;
        if($scope.currentIndex < $scope.allHelps.length){
            var currentHelp = $scope.allHelps[$scope.currentIndex];
            if($.inArray(currentHelp.scope, doNotShowHelpsAgain) == -1){
                $scope.currentElement = $('.' + currentHelp.scope);
                if($scope.currentElement.size() > 0){
                    if($scope.currentElement.is(':visible')){
                        $scope.currentElement.popover('show');
                    }else{
                        $scope.visibilityInterval = setInterval($scope.checkVisibility, 100);
                    }
                }else{
                    $scope.showNext();
                }
            }
        }
    };

    $scope.checkVisibility = function(){
        if($scope.currentElement.is(':visible')){
            $scope.currentElement.popover('show');
            clearInterval($scope.visibilityInterval);
        }
    }

    $scope.init();
}
var helpPopup = new HelpPopover(allHelps);
helpPopup.showNext();