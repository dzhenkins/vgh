<?php
$rows_count = 20;
$rows_count_second = 30;

$rows_array = [];
$rows_array_second = [];

$rows_array = [
    "1.46",
	"1.46",
    "0.51",
	"0.51",
    "1.02",
	"1.02",
    "3.10",
	"3.10",
    "2.70",
	"2.70",
    "2.04",
	"2.04",
    "5.16",
	"5.16",
    "13.13",
	"13.13",
];

// $rows_array_second = [
//     "0.75",
//     "1.31",
//     "1.03",
//     "0.25",
//     "3.47",
//     "0.83",
//     "0.47",
//     "0.32",
//     "5.51",
//     "3.93",
// ];

if (!empty($rows_array)) {
    $rows_count = count($rows_array);
}

if (!empty($rows_array_second)) {
    $rows_count_second = count($rows_array_second);
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Calc</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    </head>

    <body>

        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">My calculator</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Link</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container-fluid my-5">
            <div class="bg-light p-5 rounded">
                <h1>Calculator</h1>
                <div class="row">
                    <div class="col-10 border border-primary py-2">
                        <a class="btn btn-lg btn-primary calculate" href="#" role="button">Calculate</a>
                        <?php for ($i=0; $i<$rows_count; $i++) { ?>
                            <div class="row mb-3 border-bottom border-secondary">
                                <label for="input-<?php echo $i; ?>" class="col-sm-1 col-form-label"><?php echo $i + 1; ?>:</label>
                                <div class="col-sm-11 d-flex">
                                    <input style="max-width:140px;min-width:70px;" type="number" class="form-control left" id="input-<?php echo $i; ?>" placeholder="Enter number" value="<?php echo isset($rows_array[$i]) ? $rows_array[$i] : ''; ?>">
                                    <span class="fitter p-2" style="font-size:12px;"></span>
                                </div>
                            </div>
                        <?php } ?>
                        <a class="btn btn-lg btn-primary calculate" href="#" role="button">Calculate</a>
                    </div>
                    <div class="col-2 border border-start-0 border-primary py-2">
                        <?php for ($i=0; $i<$rows_count_second; $i++) { ?>
                            <div class="row mb-3">
                                <label for="right-input-<?php echo $i; ?>" class="col-sm-1 col-form-label"><?php echo $i + 1; ?>:</label>
                                <div class="col-sm-11 d-flex">
                                    <input style="max-width:140px;min-width:70px;" type="number" class="form-control right" id="right-input-<?php echo $i; ?>" placeholder="Enter number" value="<?php echo isset($rows_array_second[$i]) ? $rows_array_second[$i] : ''; ?>">
                                    <span class="fitter p-2" style="font-size:12px;"></span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <pre id="result"><pre>
            </div>
        </main>

        <script type="text/javascript">
            $(document).ready(function() {

                function printClosest(array, value, limit, output) {
                    var checkLength = function(array) {
                        return array.length === limit;
                    };
                    var combinations = combine(array); //get all combinations
                    combinations = limit ? combinations.filter(checkLength) : combinations;
                    var sum = combinations.map(function(c) {
                        return c.reduce(function(p, c) {
                            return p + c;
                        }, 0)
                    });
                    var sumSorted = sum.slice(0).sort(function(a, b) {
                        return a - b;
                    });

                    index = locationOf(value, sumSorted);

                    index = index >= sum.length ? sum.length - 1 : index;
                    index = sum.indexOf(sumSorted[index]);


                    var combsum = combinations[index].reduce((a, b) => a + b, 0);
                    console.log('combinations[index]',combinations[index]);
                    $('#' + output + '+span').html(combinations[index].toString() + ' SUM = ' + combsum).attr('data-sum',combsum).addClass('filled');

                    return combinations[index];
                }

                function combine(a) {
                    var fn = function(n, src, got, all) {
                        if (n == 0) {
                            if (got.length > 0) {
                                all[all.length] = got;
                            }
                            return;
                        }
                        for (var j = 0; j < src.length; j++) {
                            fn(n - 1, src.slice(j + 1), got.concat([src[j]]), all);
                        }
                        return;
                    }
                    var all = [];
                    for (var i = 0; i < a.length; i++) {
                        fn(i, a, [], all);
                    }
                    all.push(a);
                    return all;
                }

                function locationOf(element, array, start, end) {
                    start = start || 0;
                    end = end || array.length;
                    var pivot = parseInt(start + (end - start) / 2, 10);
                    if (end - start <= 1 || array[pivot] === element) return pivot;
                    if (array[pivot] < element) {
                        return locationOf(element, array, pivot, end);
                    } else {
                        return locationOf(element, array, start, pivot);
                    }
                }

                // function sortAssoc(aInput) {
                //     var aTemp = [];
                //     for (var sKey in aInput)
                //         aTemp.push([sKey, aInput[sKey]]);
                //     console.log('aTemp',aTemp);
                //     aTemp.sort(function() {
                //         return arguments[0][1] < arguments[1][1]
                //     });
                //     console.log('aTemp sort',aTemp);
                //     aTemp.reverse();
                //     console.log('aTemp reverse',aTemp);
                //
                //     var aOutput = [];
                //     for (var nIndex = aTemp.length - 1; nIndex >= 0; nIndex--)
                //         aOutput[aTemp[nIndex][0]] = aTemp[nIndex][1];
                //
                //     return aOutput;
                // }
                function sortAssoc(arr) {
                    var keys = new Array();
                    var j = 0;
                    for(var i in arr){
                        keys.push(Number(arr[i]));
                    }

                    keys.sort( (a, b) => a - b );
                    keys.reverse();

                    var sortedArray = new Array();

                    for(var i = 0; i < keys.length; i++) {
                        for(var j in arr) {
                            if (arr[j] == keys[i]) {
                                sortedArray[j] = arr[j];
                            }
                        }
                    }
                    return sortedArray;
                }

                function isInt(n){
                    return Number(n) === n && n % 1 === 0;
                }

                function isFloat(n){
                    return Number(n) === n && n % 1 !== 0;
                }

                function calculate() {

                    var arr_left_k = [];
                    // var arr_left_ko = {};
                    var arr_right = [];

                    $('input.left').each(function() {
                        if ($(this).val()) {
                            arr_left_k[$(this).attr('id')] = Number($(this).val());
                            // if (isInt($(this).val())) {
                            //     // console.log('parseInt',parseInt($(this).val()));
                            //     // arr_left_ko.$(this).attr('id') = parseInt($(this).val());
                            //     arr_left_k[$(this).attr('id')] = parseInt($(this).val());
                            // } else {
                            //     // console.log('parseFloat',parseFloat($(this).val()));
                            //     // arr_left_ko.$(this).attr('id') = parseFloat($(this).val());
                            //     arr_left_k[$(this).attr('id')] = parseFloat($(this).val());
                            // }
                        }
                    });

                    $('input.right').each(function() {
                        if ($(this).val()) {
                            arr_right.push(Number($(this).val()));
                            // if (isInt($(this).val())) {
                            //     // console.log('parseInt',parseInt($(this).val()));
                            //     arr_right.push(parseInt($(this).val()));
                            // } else {
                            //     // console.log('parseFloat',parseFloat($(this).val()));
                            //     arr_right.push(parseFloat($(this).val()));
                            // }

                        }
                    });

                    arr_left_k = sortAssoc(arr_left_k);

                    // console.log('arr_left_k',arr_left_k);
                    // console.log('arr_left_k max',arr_left_k[Object.keys(arr_left_k)[0]]);
                    // console.log('arr_right',arr_right);

                    // var right_sum = 0
                    // right_sum = arr_right.reduce((a, b) => a + b, 0)
                    //
                    // if (right_sum > arr_left_k[Object.keys(arr_left_k)[0]]) {
                    //
                    // }
                    // console.log('arr_right',arr_right);
                    for (var key in arr_left_k) {
                        if (arr_right.length == 0) {
                            continue;
                        }
                        var deletevals = printClosest(arr_right, arr_left_k[key], 0, key);
                        // console.log('deletevals',deletevals);
                        if (deletevals) {

                            // for (var i = 0; i < deletevals.length; i++) {
                            //     $('input.right').each(function() {
                            //         if (Number($(this).val()) == Number(deletevals[i])) {
                            //             $(this).val('');
                            //             return;
                            //         }
                            //     });
                            // }

                            arr_right = arr_right.filter(x => !deletevals.includes(x)).concat(deletevals.filter(x => !arr_right.includes(x)));
                        }
                    }
                    // console.log('arr_right',arr_right);
                    // if (arr_right.length) {
                    //     for (var i = 0; i < arr_right.length; i++) {
                    //         $('input.right').each(function() {
                    //             if (Number($(this).val()) == Number(arr_right[i])) {
                    //                 $(this).css('border', '1px solid red');
                    //                 return;
                    //             }
                    //         });
                    //     }
                    // }

                    $(document).find('.filled').each(function(){
                        var filled_sum = Number($(this).data('sum'));

                        var diff = 0;
                        var temp_diff = 999999999;
                        var moveto = false;

                        $(document).find('.left').each(function(){
                            var tval = Number($(this).val());

                            if (tval == filled_sum) {
                                moveto = $(this);
                                return;
                            }

                            if (tval < filled_sum) {
                                return;
                            }

                            diff = tval - filled_sum;
                            if (temp_diff > diff) {
                                temp_diff = diff;
                                moveto = $(this);
                            }

                            // if (tval > filled_sum &&) {
                            //
                            // }
                        });

                        if (moveto && moveto.next() !== $(this)) {
                            moveto.next().after($(this).clone());
                            moveto.next().remove();
                            $(this).remove();
                            // $(this).html('').removeClass('filled');
                        }
                    });
                }

                $('.calculate').on('click', function(e) {
                    e.preventDefault();
                    $('.fitter').html('');
                    calculate();
                });

            });
        </script>

    </body>

</html>
