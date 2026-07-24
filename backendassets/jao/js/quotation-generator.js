function quotationConstructor(type){
	this.type = type;
	this.modules = [{'MASTERFILE':['Chart of Account',
								'Customer',
								'Supplier',
								'Stockcard',
								'Agent',
								'Warehouse']},

					{'PURCHASES':['Purchase Requisition',
								'Purchase Order',
								'Receiving Report',
								'Purchase Return']},

					{'SALES':['Sales Order',
							'Sales Journal',
							'Sales Return']},

					{'INVENTORY':['Inventory Setup',
								'Inventory Adjust',
								'Transfer Request',
								'Transfer Slip',
								'Physical Count',
								'Material Issuance']},

					{'RECEIVABLES':['AR Setup',
								  'Received Payment',
								  'Counter Receipt']},

					{'PAYABLES':['AP Setup',
								'AP Voucher',
								'Cash / Check Voucher']},

					{'ACCOUNTING':['General Journal',
								  'Deposit Slip',
								  'Bank Reconciliation']},

					{'ACCOUNT UTILITIES':['User Access',
										 'Branch Access']},

					{'TRANSACTION UTILITIES':['System Lockdate',
											 'Manage Prefixes',
											 'Manage Terms',
											 'Change Item',
											 'Audit Trail',
											 'Unposted Transactions',
											 'Extractor']},

					{'OTHER UTILITIES':['Theme Customizer',
									   'Scheduler',
									   'Stockcard',
									   'Agent',
									   'Warehouse']},
					];

	this.reports = [{'Accounting Books':['Cash Disbursement Book','Cash Receipt Book','Journal Voucher','Purchase Journal','Sales Journal','Chart of Accounts']},
					
					{'Check Monitoring Reports':['Bounced Checks','Issued Checks','Received Checks','Undeposited Checks']},
					
					{'Financial Statements':['Balance Sheet','Income Statement','Subsidiary Ledger','Trial Balance','Comparative Income Statement','Comparative Balance Sheet','Monthly Income Statement']},
					
					{'Items':['Inventory Balance','Analyze Item Purchase (Monthly)','Analyze Item Sales (Monthly)','Item List','Current Inventory Aging','Fast Moving Items',
					'Analyze Item Sales with Profit Markup','Slow Moving Items','Sales per Item per Customer','Item to Expired','Item Balance - Below Minimum','Item Balance - Above Maximum',
					'Physical Inventory Sheet','Item Purchase Report']},
					
					{'Customers':['Customer List','Current Customer Receivables','Current Customer Receivables Aging',
					'Analyze Customer Sales (Monthly)','Customer Sales Report','Pending Sales Order','Monthly Sales Report (Graph)','Customer Performance Report',
					'Sales per Customer per Item','Sales Comparison','Sales per Customer','Analyze Customer Collection Monthly']},
					
					{'Supplier':['Supplier List','Current Supplier Payables','Current Supplier Payable Aging',
					'Analyzed Supplier Purchases (Monthly)','Supplier Purchase Report','Pending Purchase Order','Supplier Performance Report','Purchase per Supplier']},
					
					{'Sales Agent':['Sales Agent List','Analyzed Agent Sales (Monthly)']},

					{'Other Reports':['Statement of Account','Expenses Report']},

					{'Transaction List':['Sales','Purchase','Inventory','Payables','Receivables','Accounting']},

				   ];
}//End function

quotationConstructor.prototype = {
	constructor: quotationConstructor,
	
	setDefaultHeader:function(){
		
	},//end function

	setDefaultModules : function(){
		var g = this.reports
		$.each(g, function(index,key){
			// console.log(key);
			$.each(key, function(indexx,key2){
				// console.log(key2);
			});
		});
	},//end function

	setDefaultReports : function(){

	}//end function


}//end combooptionloader prototype