function MakeBM(){var Text=document.BMMaker.Input.value;Text=Text.replace(/\r/g,"\n");Text=Text.replace(/[\t ]+/g," ");Text=Text.replace(/'/g,'"<$<$<$<$<$<');var NewlineArray=Text.split("\n");var LineCount=NewlineArray.length;var QuoteArray=Array();var SplitCount=0;for(i=0;i<LineCount;i++){NewlineArray[i]=NewlineArray[i].replace(/^[\t ]+/g,"");NewlineArray[i]=NewlineArray[i].replace(/[\t ]+$/g,"");QuoteArray=NewlineArray[i].split('"');SplitCount=QuoteArray.length;for(j=0;j<SplitCount;j++){if((j%2)==0){QuoteArray[j]=MakeReplaces(QuoteArray[j])}}NewlineArray[i]=QuoteArray.join('"')}Text=NewlineArray.join("");Text=Text.replace(/"<\$<\$<\$<\$<\$</g,"'");Text=Text.replace(/%/g,"%25");Text=Text.replace(/"/g,"%22");Text=Text.replace(/</g,"%3C");Text=Text.replace(/>/g,"%3E");Text=Text.replace(/#/g,"%23");Text=Text.replace(/@/g,"%40");Text=Text.replace(/ /g,"%20");Text=Text.replace(/\&/g,"%26");Text=Text.replace(/\?/g,"%3F");if(Text.substring(0,11)=="javascript:"){Text=Text.substring(11)}TextLength=Text.length;if((Text.substring(0,12)+Text.substring(TextLength-5))!="(function(){})();"){Text="(function(){"+Text+"})();"}Text="javascript:"+Text;document.BMMaker.Output.value=Text}function MakeReplaces(Text){Text=Text.replace(/ ?; ?/g,";");Text=Text.replace(/ ?: ?/g,":");Text=Text.replace(/ ?, ?/g,",");Text=Text.replace(/ ?= ?/g,"=");Text=Text.replace(/ ?% ?/g,"%");Text=Text.replace(/ ?\+ ?/g,"+");Text=Text.replace(/ ?\* ?/g,"*");Text=Text.replace(/ ?\? ?/g,"?");Text=Text.replace(/ ?\{ ?/g,"{");Text=Text.replace(/ ?\} ?/g,"}");Text=Text.replace(/ ?\[ ?/g,"[");Text=Text.replace(/ ?\] ?/g,"]");Text=Text.replace(/ ?\( ?/g,"(");Text=Text.replace(/ ?\) ?/g,")");return Text};