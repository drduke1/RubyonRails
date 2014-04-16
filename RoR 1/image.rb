class Image < ActiveRecord::Base
  attr_accessible :category, :img, :img_name, :product
  
  has_attached_file :img, :styles => { :thumb => ["260x200>", :jpg] }
  
  default_scope order('product DESC')
end
