tOffsetOf(RenderSliver child);

  /// Returns the scroll offset within the viewport for the given
  /// `scrollOffsetWithinChild` within the given `child`.
  ///
  /// The returned value is an estimate that assumes the slivers within the
  /// viewport do not change the layout extent in response to changes in their
  /// scroll offset.
  @protected
  double scrollOffsetOf(RenderSliver child, double scrollOffsetWithinChild);

  /// Returns the total scroll obstruction extent of all slivers in the viewport
  /// before [child].
  ///
  /// This is the extent by which the actual area in which content can scroll
  /// is reduced. For example, an app bar that is pinned at the top will reduce
  /// the area in which content can actually scroll by the height of the app bar.
  @protected
  double maxScrollObstructionExtentBefore(RenderSliver child);

  /// Converts the `parentMainAxisPosition` into the child's coordinate system.
  ///
  /// The `parentMainAxisPosition` is a distance from the top edge (for vertical
  /// viewports) or left edge (for horizontal viewports) of the viewp