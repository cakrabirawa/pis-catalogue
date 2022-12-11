<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class Form1
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
    Me.txtInput = New System.Windows.Forms.TextBox()
    Me.richLog = New System.Windows.Forms.RichTextBox()
    Me.cmdStart = New System.Windows.Forms.Button()
    Me.progressBar = New System.Windows.Forms.ProgressBar()
    Me.Label1 = New System.Windows.Forms.Label()
    Me.Label2 = New System.Windows.Forms.Label()
    Me.txtOuput = New System.Windows.Forms.TextBox()
    Me.SuspendLayout()
    '
    'txtInput
    '
    Me.txtInput.Font = New System.Drawing.Font("Tahoma", 8.0!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
    Me.txtInput.Location = New System.Drawing.Point(143, 12)
    Me.txtInput.Name = "txtInput"
    Me.txtInput.Size = New System.Drawing.Size(802, 27)
    Me.txtInput.TabIndex = 1
    Me.txtInput.Text = "c:\piselex\prosesprod\"
    '
    'richLog
    '
    Me.richLog.BackColor = System.Drawing.Color.Black
    Me.richLog.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
    Me.richLog.ForeColor = System.Drawing.Color.Red
    Me.richLog.Location = New System.Drawing.Point(12, 127)
    Me.richLog.Name = "richLog"
    Me.richLog.ScrollBars = System.Windows.Forms.RichTextBoxScrollBars.Vertical
    Me.richLog.Size = New System.Drawing.Size(933, 597)
    Me.richLog.TabIndex = 2
    Me.richLog.Text = ""
    '
    'cmdStart
    '
    Me.cmdStart.Location = New System.Drawing.Point(143, 83)
    Me.cmdStart.Name = "cmdStart"
    Me.cmdStart.Size = New System.Drawing.Size(197, 38)
    Me.cmdStart.TabIndex = 3
    Me.cmdStart.Text = "Start"
    Me.cmdStart.UseVisualStyleBackColor = True
    '
    'progressBar
    '
    Me.progressBar.Location = New System.Drawing.Point(349, 83)
    Me.progressBar.Name = "progressBar"
    Me.progressBar.Size = New System.Drawing.Size(595, 38)
    Me.progressBar.TabIndex = 4
    '
    'Label1
    '
    Me.Label1.AutoSize = True
    Me.Label1.Location = New System.Drawing.Point(12, 20)
    Me.Label1.Name = "Label1"
    Me.Label1.Size = New System.Drawing.Size(116, 19)
    Me.Label1.TabIndex = 5
    Me.Label1.Text = "Directory Input"
    '
    'Label2
    '
    Me.Label2.AutoSize = True
    Me.Label2.Location = New System.Drawing.Point(12, 53)
    Me.Label2.Name = "Label2"
    Me.Label2.Size = New System.Drawing.Size(127, 19)
    Me.Label2.TabIndex = 6
    Me.Label2.Text = "Directory Output"
    '
    'txtOuput
    '
    Me.txtOuput.Font = New System.Drawing.Font("Tahoma", 8.0!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
    Me.txtOuput.Location = New System.Drawing.Point(143, 50)
    Me.txtOuput.Name = "txtOuput"
    Me.txtOuput.Size = New System.Drawing.Size(802, 27)
    Me.txtOuput.TabIndex = 7
    '
    'Form1
    '
    Me.AutoScaleDimensions = New System.Drawing.SizeF(144.0!, 144.0!)
    Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Dpi
    Me.ClientSize = New System.Drawing.Size(956, 525)
    Me.Controls.Add(Me.txtOuput)
    Me.Controls.Add(Me.Label2)
    Me.Controls.Add(Me.Label1)
    Me.Controls.Add(Me.progressBar)
    Me.Controls.Add(Me.cmdStart)
    Me.Controls.Add(Me.richLog)
    Me.Controls.Add(Me.txtInput)
    Me.Font = New System.Drawing.Font("Tahoma", 8.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
    Me.MaximizeBox = False
    Me.Name = "Form1"
    Me.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen
    Me.Text = "Publishers Information System Catalogue Tools"
    Me.ResumeLayout(False)
    Me.PerformLayout()

  End Sub
  Friend WithEvents txtInput As System.Windows.Forms.TextBox
  Friend WithEvents richLog As System.Windows.Forms.RichTextBox
  Friend WithEvents cmdStart As System.Windows.Forms.Button
  Friend WithEvents progressBar As System.Windows.Forms.ProgressBar
  Friend WithEvents Label1 As System.Windows.Forms.Label
  Friend WithEvents Label2 As System.Windows.Forms.Label
  Friend WithEvents txtOuput As System.Windows.Forms.TextBox

End Class
