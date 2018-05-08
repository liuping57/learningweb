function realsecode()
{
	$("#codes").val("");
	$("#output").text("");
}
 $(function () {
	$("#select1").bind("change",function () {  
   	if (this.value== 1)
   	{
   		$("#codes").val('#include <stdio.h>\nint main()\n{\n        printf("HelloWorld!");\n}');
   	}
   	else if(this.value==2)
   	{
   		$("#codes").val('#include<iostream>\nusing namespace std;\nint main(void)\n{\n        cout<<"hello world"<<endl;\n        return 0;\n}');
   	}
   	else if(this.value==3)
   	{
   		$("#codes").val('public class HelloWorld {\n    public static void main(String[] agrs)\n    {\n        System.out.println("HelloWorld!");\n    }\n}');
   	}
   	else if(this.value==4)
   	{
   		$("#codes").val('#!/usr/bin/python\nprint("Hello, World!");');
   	}
   	else if(this.value==5)
   	{
   		$("#codes").val('package main\n\nimport "fmt"\n\nfunc main() {\n    fmt.Println("Hello, World!")\n}');
   	}   
 })
});