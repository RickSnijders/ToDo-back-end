var taskNmbr = 1;
		// adds the task fields
		function addTask(){
			
			var form = document.getElementById("form");
			var container = document.createElement("div");
			form.appendChild(container);

			//Title Task ..
			var newtitle = document.createElement("h4");
			newtitle.innerHTML = "Task "+taskNmbr;
			container.appendChild(newtitle);

			// Div for Title
			var titlediv = document.createElement("div");
			titlediv.classList.add("form-group");
			container.appendChild(titlediv);

			//Label for Title input
			var newtitlelabel = document.createElement("label");
			newtitlelabel.innerHTML = "Title";
			titlediv.appendChild(newtitlelabel);

			//Input for Title
			var titleinput = document.createElement("input");
			titleinput.type = "text";
			titleinput.name = "title"+taskNmbr;
			titleinput.placeholder = "Title";
			titleinput.classList.add("form-control");
			titlediv.appendChild(titleinput);	

			// Div for Description
			var descdiv = document.createElement("div");
			descdiv.classList.add("form-group");
			container.appendChild(descdiv);

			//Label for Description input
			var newdescriptionlabel = document.createElement("label");
			newdescriptionlabel.innerHTML = "Description";
			descdiv.appendChild(newdescriptionlabel);

			//Input for Description
			var descriptioninput = document.createElement("textarea");
			descriptioninput.type = "text";
			descriptioninput.rows = "3";
			descriptioninput.name = "description"+taskNmbr;
			descriptioninput.placeholder = "Description";
			descriptioninput.classList.add("form-control");
			descdiv.appendChild(descriptioninput);

			// Div for Duration
			var durationdiv = document.createElement("div");
			durationdiv.classList.add("form-group");
			container.appendChild(durationdiv);

			//Label for Duration input
			var newdurationlabel = document.createElement("label");
			newdurationlabel.innerHTML = "Duration";
			durationdiv.appendChild(newdurationlabel);

			//Input for Duration
			var durationinput = document.createElement("input");
			durationinput.type = "number";
			durationinput.name = "duration"+taskNmbr;
			durationinput.placeholder = "Duration";
			durationinput.classList.add("form-control");
			durationdiv.appendChild(durationinput);


			document.getElementById("count").value = taskNmbr;
			taskNmbr++;
		}